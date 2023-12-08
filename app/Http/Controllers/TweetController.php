<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tag;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::all();
        return $tweets;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'tags' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tags = explode(" ", $request->tags);

        $tweet = Tweet::create([
            'content' => $request->content,
            'theme' => $request->theme,
            'user_id' => Auth::user()->id,
        ]);

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'tweet_id' => $tweet->id
            ]);
        };

        return response()->json([
            'message' => 'Tweet is posted!',
            'tweet' => new TweetResource($tweet),
            'tags' => $tags
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show($tweet_id)
    {
        $tweet = Tweet::find($tweet_id);
        if (is_null($tweet)) {
            return response()->json('Tweet not found', 404);
        }
        return response()->json($tweet);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tweet $tweet)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'theme' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tweet->content = $request->content;
        $tweet->theme = $request->theme;

        $tweet->save();

        return response()->json([
            'message' => 'Tweet was edited!',
            'tweet' => new TweetResource($tweet),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return response()->json('Tweet was removed!');
    }
}

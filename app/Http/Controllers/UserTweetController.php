<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class UserTweetController extends Controller
{
    public function index($user_id)
    {
        $tweets = Tweet::get()->where('user_id', $user_id);
        if (is_null($tweets) || $tweets->isEmpty()) {
            return response()->json('This user did not post anything', 404);
        }
        return response()->json($tweets);
    }
}

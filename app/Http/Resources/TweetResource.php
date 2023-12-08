<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'tweet';

    public function toArray($request)
    {
        return [
            'theme' => $this->resource->theme,
            'content' => $this->resource->content,
            'author' => new UserResource($this->resource->user)
        ];
    }
}

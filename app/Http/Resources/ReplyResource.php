<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReplyResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'body' => $this->body,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_humanized' => $this->updated_at->diffForHumans(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'sub_replies' => $this->when($this->subReplies, ReplyResource::collection($this->subReplies)),
        ];
    }
}

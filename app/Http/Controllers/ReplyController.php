<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CreateRepliesRequest;
use App\Reply;
use App\Http\Resources\ReplyCollection;
use App\Http\Resources\ReplyResource;

class ReplyController extends Controller
{
    protected Reply $model;

    public function __construct(Reply $comment)
    {
        $this->model = $comment;
    }

    /**
     * Get replies that belong to the specified comment.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
        $replies = $comment->replies()->with('subReplies')->latest()->paginate(20);

        return json(['replies' => new ReplyCollection($replies)], 'replies gotten');
    }

    /**
     * Create a reply for the specified comment.
     *
     * @param  \App\Comment  $comment
     * @param  \App\Requests\CreateRepliesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Comment $comment, CreateRepliesRequest $request)
    {
        $reply = $comment->replies()->create($request->validated());

        return json(['reply' => new ReplyResource($reply)], 'reply created');
    }

    /**
     * Create a sub reply for the specified reply.
     *
     * @param  \App\Reply  $reply
     * @param  \App\Requests\CreateRepliesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createSubReply(Reply $reply, CreateRepliesRequest $request)
    {
        if ($reply->isSubReply()) {
            return message("you cannot reply a sub reply", 405);
        }

        $reply = $reply->subReplies()->create($request->validated());

        return json(['reply' => new ReplyResource($reply)], 'reply created');
    }

    /**
     * Create a sub reply for the specified reply.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function getSubReplies(Reply $reply)
    {
        $subReplies = $reply->subReplies()->latest()->paginate(20);

        return json(['sub_replies' => new ReplyCollection($subReplies)], 'sub replies gotten');
    }
}

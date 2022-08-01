<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreateRepliesRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\ReplyResource;

class CommentController extends Controller
{
    protected Comment $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $comments = $this->model->paginate(20);
        $comments = $this->model->with(['replies.replies'])->paginate(20);

        return json(['comments' => new CommentCollection($comments)], "comments gotten");
    }

    /**
     * Create a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateCommentRequest $request)
    {
        $comment = $this->model->create($request->validated());

        return json(['comment' => new CommentResource($comment)], 'comment created');
    }

    /**
     * Create a reply for the specified comment.
     *
     * @param  \App\Comment  $comment
     * @param  \App\Requests\CreateRepliesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createReply(Comment $comment, CreateRepliesRequest $request)
    {
        $reply = $comment->replies()->create($request->validated());

        return json(['reply' => new ReplyResource($reply)], 'reply created');
    }
}

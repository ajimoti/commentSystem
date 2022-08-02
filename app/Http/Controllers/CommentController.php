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
        $comments = $this->model->with(['replies.subReplies'])->latest()->paginate(20);
        
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
}

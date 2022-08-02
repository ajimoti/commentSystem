<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ReplyScope;

class Reply extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'user_name',
        'body',
        'parent_id',
    ];

    /**
     * Comment
     *
     * @return BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Parent Reply
     *
     * @return BelongsTo
     */
    public function parentReply()
    {
        return $this->belongsTo(Reply::class, 'parent_id');
    }

    /**
     * Replies
     *
     * @return BelongsTo
     */
    public function subReplies()
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    /**
     * Checks if the reply is at the third layer
     *
     * @return bool
     */
    public function isSubReply() 
    {
        return ! empty($this->parentReply);
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReplyScope);
    }
}

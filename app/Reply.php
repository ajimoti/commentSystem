<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}

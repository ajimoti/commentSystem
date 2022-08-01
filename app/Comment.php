<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Scopes\CommentScope;

class Comment extends Model
{
    protected $fillable = [
        'user_name',
        'body',
        'parent_id',
    ];

    /**
     * Comment replies
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CommentScope);
    }
}

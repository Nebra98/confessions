<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_comment_id', 'user_id', 'confession_id', 'comment', 'comment_sender_name'
    ];

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id')->with('replies');
    }

    // Relationship to Confession
    public function confession(){
        return $this->belongsTo(Confession::class, 'confession_id');
    }

    public function likes()
    {
        return $this->hasMany(LikeComment::class, 'comment_id');
    }

}

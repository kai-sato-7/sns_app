<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Comment extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
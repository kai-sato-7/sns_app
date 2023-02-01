<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function post_reactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function comment_reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function outgoing_requests()
    {
        return $this->hasMany(FriendRequest::class, 'outgoing_user_id');
    }

    public function ingoing_requests()
    {
        return $this->hasMany(FriendRequest::class, 'ingoing_user_id');
    }

    public function users_sent_requests()
    {
        return $this->hasManyThrough(User::class, FriendRequest::class, 'ingoing_user_id', 'id', 'id', 'outgoing_user_id');
    }

    public function users_received_requests()
    {
        return $this->hasManyThrough(User::class, FriendRequest::class, 'outgoing_user_id', 'id', 'id', 'ingoing_user_id');
    }

    public function friends()
    {
        return $this->hasManyThrough(User::class, Relation::class, 'user_id', 'id', 'id', 'friend_user_id');
    }
}

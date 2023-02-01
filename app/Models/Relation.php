<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Relation extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'friend_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function connected_user()
    {
        return $this->belongsTo(User::class, 'friend_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FriendRequest extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'outgoing_user_id',
        'ingoing_user_id',
    ];
}

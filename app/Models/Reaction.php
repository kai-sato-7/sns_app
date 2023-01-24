<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Reaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'post_id',
        'user_id',
        'like',
    ];
}
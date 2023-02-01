<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function edit(Request $request): View
    {
        $posts = Post::select('id', 'user_id', 'title', 'content', 'file_name')->latest()->get();
        foreach ($posts as $post) {
            $post->username = $post->user->username;
        }
        return view('feed', ['posts' => $posts]);
    }
}

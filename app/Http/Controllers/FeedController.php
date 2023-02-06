<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function edit(Request $request): View
    {
        $posts = Post::latest()->get();
        foreach ($posts as $post) {
            $post->username = $post->user->username;
            $post->like = PostReaction::where('post_id', $post->id)->where('user_id', $request->user()->id)->value('like');
            $post->total_likes = 0;
            $likes = PostReaction::where('post_id', $post->id)->pluck('like')->toArray();
            foreach ($likes as $like) {
                $post->total_likes += $like * 2 - 1;
            }
            $post = $post->only(['id', 'username', 'title', 'content', 'file_name', 'like', 'total_likes']);
        }
        return view('feed', ['posts' => $posts]);
    }
}

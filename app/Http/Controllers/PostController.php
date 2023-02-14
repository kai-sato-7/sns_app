<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReaction;
use App\Http\Requests\MakePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    public function edit(Request $request): View
    {
        $posts = $request->user()->posts->sortByDesc('created_at')->values()->map(function ($item) use ($request) {
            $item->username = $request->user()->username;
            $item->new_id = 'id'.$item->id;
            $item->like = PostReaction::where('post_id', $item->id)->where('user_id', $request->user()->id)->value('like');
            $item->total_likes = 0;
            $item->total_dislikes = 0;
            $likes = PostReaction::where('post_id', $item->id)->pluck('like')->toArray();
            foreach ($likes as $like) {
                $item->total_likes += $like;
                $item->total_dislikes += 1 - $like;
            }
            return $item->only(['id', 'new_id', 'username', 'title', 'content', 'file_name', 'like', 'total_likes', 'total_dislikes', 'created_at']);
        });
        return view('posts', ['posts' => $posts]);
    }

    public function update(MakePostRequest $request): RedirectResponse
    {
        if ($request->action === "cancel") {
            return Redirect::route('posts.edit');
        }
        if ($request->hasFile('file')) {
            $request->file->store('public/images');
            $file_name = $request->file->hashName();
            Post::create([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'file_name' => $file_name,
            ]);
        } else {
            Post::create([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
        return Redirect::route('posts.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        return Redirect::route('posts.edit');
    }
}

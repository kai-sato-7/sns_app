<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Http\Requests\MakePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    public function edit(Request $request): View
    {
        $posts = $request->user()->posts->sortByDesc('created_at')->only(['id', 'user_id', 'title', 'content', 'file_name']);
        foreach ($posts as $post) {
            $post->username = $request->user()->username;
        }
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

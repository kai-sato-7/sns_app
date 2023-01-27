<?php

namespace App\Http\Controllers;

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
        $posts = Post::select('text', 'image_path')->where('user_id', $request->user()->id)->get();
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
                'text' => $request->text,
                'image_path' => $file_name,
            ]);
        } else {
            Post::create([
                'user_id' => $request->user()->id,
                'text' => $request->text,
            ]);
        }
        return Redirect::route('posts.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        return Redirect::route('posts.edit');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\MakeCommentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function update(MakeCommentRequest $request): RedirectResponse
    {
        $parent = Comment::findOr($request->parent_id);
        if ($parent->exists()) {
            $parent_path = $parent->path;
        } else {
            $parent_path = '/';
        }
        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
            'content' => $request->content,
            'path' => $parent_path.$request->parent_id.'/',
        ]);
        return back();
    }
}

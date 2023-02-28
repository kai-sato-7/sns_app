<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\MakeCommentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function update(MakeCommentRequest $request): RedirectResponse
    {
        $comment = new Comment;
        $comment->user_id = $request->user()->id;
        $comment->content = $request->content;
        
        if ($request->parent_id != -1) {
            $parent_comment = Comment::find($request->parent_id);
            $comment->level = $parent_comment->level + 1;
            $parent_comment->comments()->save($comment);
        } else {
            $comment->level = 1;
            $parent_post = Post::find($request->post_id);
            $parent_post->comments()->save($comment);
        }

        return back();
    }
}

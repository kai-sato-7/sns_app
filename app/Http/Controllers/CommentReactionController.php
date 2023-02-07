<?php

namespace App\Http\Controllers;

use App\Models\CommentReaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentReactionController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $reaction = CommentReaction::where('user_id', $request->user()->id)->where('comment_id', $request->id);
        if ($reaction->value('like') == $request->like) {
            $reaction->delete();
        } else {
            CommentReaction::updateOrInsert(['user_id' => $request->user()->id,'comment_id' => $request->id], ['like' => $request->like]);
        }
        return back();
    }
}

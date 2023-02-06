<?php

namespace App\Http\Controllers;

use App\Models\PostReaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostReactionController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $reaction = PostReaction::where('user_id', $request->user()->id)->where('post_id', $request->id);
        if ($reaction->value('like') == $request->like) {
            $reaction->delete();
        } else {
            PostReaction::updateOrInsert(['user_id' => $request->user()->id,'post_id' => $request->id], ['like' => $request->like]);
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\FriendRequest;
use App\Models\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FriendController extends Controller
{
    public function edit(Request $request): View
    {
        $friends = $request->user()->friends;
        $posts = [];
        foreach ($friends as $friend) {
            foreach ($friend->posts as $post) {
                $post->username = $post->user->username;
                array_push($posts, $post);
            }
        }
        $posts = collect($posts)->sortByDesc('created_at')->values()->map(function ($item) {
            $ret = collect($item);
            $ret->like = PostReaction::where('post_id', $ret->id)->where('user_id', $request->user()->id)->value('like');
            $item->total_likes = 0;
            $likes = PostReaction::where('post_id', $item->id)->pluck('like')->toArray();
            foreach ($likes as $like) {
                $item->total_likes += $like * 2 - 1;
            }
            return ret->only(['id', 'username', 'title', 'content', 'file_name', 'like', 'total_likes']);
        });
        return view('friends', ['posts' => $posts]);
    }

    public function update(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        Relation::create([
            'user_id' => $id,
            'friend_user_id' => $request->user()->id,
        ]);
        Relation::create([
            'friend_user_id' => $id,
            'user_id' => $request->user()->id,
        ]);
        FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
        return Redirect::route('friend_requests.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        Relation::where('user_id', $id)->where('friend_user_id', $request->user()->id)->delete();
        Relation::where('friend_user_id', $id)->where('user_id', $request->user()->id)->delete();
        return Redirect::route('friends.edit');
    }
}

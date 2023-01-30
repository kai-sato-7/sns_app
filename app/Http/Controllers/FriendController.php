<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
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
        $friend_ids_1 = User::select('users.*')->join('relations', 'relations.user_id_1', '=', 'users.id')->where('user_id_2', $request->user()->id)->pluck('id')->toArray();
        $friend_ids_2 = User::select('users.*')->join('relations', 'relations.user_id_2', '=', 'users.id')->where('user_id_1', $request->user()->id)->pluck('id')->toArray();
        $friend_ids = array_merge($friend_ids_1, $friend_ids_2);
        $friend_usernames = User::select('username')->whereIn('user_id', $friend_ids)->get();
        $posts = Post::select('id', 'user_id', 'title', 'content', 'file_name')->whereIn('user_id', $friend_ids)->get();
        foreach ($posts as $post) {
            $post->username = User::where('id', $post->user_id)->value('username');
        }
        return view('friends', ['usernames' => $friend_usernames, 'posts' => $posts]);
    }

    public function update(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        if ($id < $request->user()->id) {
            Relation::create([
                'user_id_1' => $id,
                'user_id_2' => $request->user()->id,
            ]);
        } else {
            Relation::create([
                'user_id_2' => $id,
                'user_id_1' => $request->user()->id,
            ]);
        }
        FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
        return Redirect::route('friend_requests.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        if ($id < $request->user()->id) {
            Relation::where('user_id_1', $id)->where('user_id_2', $request->user()->id)->delete();
        } else {
            Relation::where('user_id_2', $id)->where('user_id_1', $request->user()->id)->delete();
        }
        return Redirect::route('friends.edit');
    }
}

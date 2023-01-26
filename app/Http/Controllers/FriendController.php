<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $friend_usernames_1 = User::select('users.*')->join('relations', 'relations.user_id_1', '=', 'users.id')->where('user_id_2', $request->user()->id)->pluck('username')->toArray();
        $friend_usernames_2 = User::select('users.*')->join('relations', 'relations.user_id_2', '=', 'users.id')->where('user_id_1', $request->user()->id)->pluck('username')->toArray();
        return view('friends', ['usernames' => array_merge($friend_usernames_1, $friend_usernames_2)]);
    }

    public function update(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        $relation = new Relation;
        if ($id < $request->user()->id) {
            $relation->user_id_1 = $id;
            $relation->user_id_2 = $request->user()->id;
        } else {
            $relation->user_id_1 = $request->user()->id;
            $relation->user_id_2 = $id;
        }
        $relation->save();
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

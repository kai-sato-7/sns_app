<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFriendRequestRequest;
use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FriendRequestController extends Controller
{
    public function edit(Request $request): View
    {
        $joined_table = User::select('users.*')->join('friend_requests', 'friend_requests.outgoing_user_id', '=', 'users.id');
        return view('friend_requests', [
            'usernames' => $joined_table->where('ingoing_user_id', $request->user()->id)->pluck('username'),
        ]);
    }

    public function update(AddFriendRequestRequest $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        if (FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->exists()) {
            FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
            $relation = new Relation;
            if ($id < $request->user()->id) {
                $relation->user_id_1 = $id;
                $relation->user_id_2 = $request->user()->id;
            } else {
                $relation->user_id_1 = $request->user()->id;
                $relation->user_id_2 = $id;
            }
            $relation->save();
        } else {
            $friend_request = new FriendRequest;
            $friend_request->outgoing_user_id = $request->user()->id;
            $friend_request->ingoing_user_id = $id;
            $friend_request->save();
        }
        return Redirect::route('friend_requests.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
        return Redirect::route('friend_requests.edit');
    }
}
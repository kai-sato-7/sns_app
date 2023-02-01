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
        $usernames = $request->user()->users_sent_requests->pluck('username');
        return view('friend_requests', [
            'usernames' => $usernames,
        ]);
    }

    public function update(AddFriendRequestRequest $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        if (FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->exists()) {
            FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
            Relation::create([
                'user_id' => $id,
                'friend_user_id' => $request->user()->id,
            ]);
            Relation::create([
                'user_id' => $id,
                'friend_user_id' => $request->user()->id,
            ]);
        } else {
            FriendRequest::create([
                'outgoing_user_id' => $request->user()->id,
                'ingoing_user_id' => $id,
            ]);
        }
        return Redirect::route('friend_requests.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $id = User::where('username', $request->username)->value('id');
        FriendRequest::where('outgoing_user_id', $id)->where('ingoing_user_id', $request->user()->id)->delete();
        FriendRequest::where('outgoing_user_id', $request->user()->id)->where('ingoing_user_id', $id)->delete();
        return Redirect::route('friend_requests.edit');
    }
}
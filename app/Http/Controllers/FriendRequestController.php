<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFriendRequestRequest;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FriendRequestController extends Controller
{
    public function edit(Request $request): View
    {
        return view('friend_requests');
    }

    public function update(AddFriendRequestRequest $request): View
    {
        $friend_request = new FriendRequest;
        $friend_request->outgoing_user_id = $request->user()->id;
        $friend_request->ingoing_user_id = User::where('username', $request->username)->value('id');
        $friend_request->save();
        return view('friend_requests');
    }
}
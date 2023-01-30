<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageFriendController extends Controller
{
    public function edit(Request $request): View
    {
        $friend_usernames_1 = User::select('users.*')->join('relations', 'relations.user_id_1', '=', 'users.id')->where('user_id_2', $request->user()->id)->pluck('username')->toArray();
        $friend_usernames_2 = User::select('users.*')->join('relations', 'relations.user_id_2', '=', 'users.id')->where('user_id_1', $request->user()->id)->pluck('username')->toArray();
        $friend_usernames = array_merge($friend_usernames_1, $friend_usernames_2);
        return view('manage_friends', ['usernames' => $friend_usernames]);
    }
}

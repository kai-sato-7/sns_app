<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageFriendController extends Controller
{
    public function edit(Request $request): View
    {
        $friend_usernames = $request->user()->friends->pluck('username');
        return view('manage_friends', ['usernames' => $friend_usernames]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFriendRequest;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FriendRequestController extends Controller
{
    public function view(Request $request): View
    {
        return view('friend_requests');
    }

    public function add(AddFriendRequest $request): View
    {
        
        return view('friend_requests');
    }
}

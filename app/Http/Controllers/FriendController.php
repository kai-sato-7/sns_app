<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FriendController extends Controller
{
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
}

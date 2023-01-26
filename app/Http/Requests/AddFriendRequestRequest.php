<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddFriendRequestRequest extends FormRequest
{
    protected $errorBag = 'addRequest';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $joined_table = User::select('users.*')->join('friend_requests', 'friend_requests.ingoing_user_id', '=', 'users.id');
        $friend_usernames_1 = User::select('users.*')->join('relations', 'relations.user_id_1', '=', 'users.id')->where('user_id_2', Auth::id())->pluck('username')->toArray();
        $friend_usernames_2 = User::select('users.*')->join('relations', 'relations.user_id_2', '=', 'users.id')->where('user_id_1', Auth::id())->pluck('username')->toArray();
        return [
            'username' => [
                'required',
                'exists:users,username',
                'not_in:'.Auth::user()->username,
                'not_in:'.implode(',', $joined_table->where('outgoing_user_id', Auth::id())->pluck('username')->toArray()),
                'not_in:'.implode(',', array_merge($friend_usernames_1, $friend_usernames_2)),
            ],
        ];
    }
}

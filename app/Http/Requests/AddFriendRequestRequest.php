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
        return [
            'username' => [
                'required',
                'exists:users,username',
                'not_in:'.Auth::user()->username,
                'not_in:'.implode(',', Auth::user()->users_received_requests->pluck('username')->toArray()),
                'not_in:'.implode(',', Auth::user()->friends->pluck('username')->toArray()),
            ],
        ];
    }
}

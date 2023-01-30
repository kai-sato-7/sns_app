<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakePostRequest extends FormRequest
{
    protected $errorBag = 'makePost';
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
            'title' => ['exclude_if:action,cancel', 'required', 'string', 'max:100'],
            'content' => ['exclude_if:action,cancel', 'max:1000'],
            'file' => ['exclude_if:action,cancel', 'image'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'uid' => 'required|unique:users,uid',
            'email' => 'required|email:rfc,dns|unique:users,email',
            //  'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ];
    }
}
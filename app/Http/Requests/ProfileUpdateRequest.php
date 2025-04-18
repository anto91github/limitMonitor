<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        // Let's get the route param by name to get the User object value
        $user = request()->route('user');
        $userId = $this->user->id;

        return [
           'name' => 'required',
           'uid' => 'required|unique:users,uid,' . $userId,
           'email' => 'required|email:rfc,dns|unique:users,email,' . $userId,
           //  'username' => 'required|unique:users,username',
           'password' => 'nullable|min:5',
           'confirm_password' => 'nullable|same:password',
        ];
    }
}

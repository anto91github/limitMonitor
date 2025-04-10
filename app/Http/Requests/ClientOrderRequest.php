<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientOrderRequest extends FormRequest
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
            'client' => 'required',
            'bors' => 'required',
            'obligasi' => 'required',
            'nominal' => 'required',
            'harga' => 'required',
            'amount' => 'required',
            'sett_date' => 'required'
        ];
    }
}
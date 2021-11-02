<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditContact extends FormRequest
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
            'profile-name' => 'required|max:255',
            'profile-lastname' => 'required|max:255',
            'profile-phone' => 'sometimes',
            'profile-email' => 'required|email:rfc',
            'profile-password' => 'sometimes',
            'profile-fonction' => 'sometimes'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'profile-id' => 'sometimes',
            'profile-name' => 'sometimes',
            'profile-lastname' => 'sometimes',
            'profile-img-input' => 'sometimes',
            'profile-email' => 'sometimes',
            'profile-password' => 'sometimes',
            'profile-img' => 'sometimes|image|mimes:png,jpeg,gif,svg+xml',
        ];
    }
}

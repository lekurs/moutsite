<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
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
            'contact-firstname' => 'required|max:255',
            'contact-lastname' => 'required|max:255',
            'contact-phone' => 'required|max:10',
            'contact-email' => 'required|max:255',
            'contact-functions' => '',
            'contact-picture' => '',
            'contact-slug' => ''
        ];
    }
}

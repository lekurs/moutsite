<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'client-name' => 'required|max:255',
            'client-phone' => 'sometimes',
            'client-address' => 'required',
            'client-zip' => 'required',
            'client-city' => 'required',
            'client-logo' => 'sometimes',
            'client-slug' => 'sometimes',
            'client-siren' => 'sometimes'
        ];
    }
}

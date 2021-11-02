<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreService extends FormRequest
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
            'service-libelle' => 'required|max:255',
            'service-description' => 'required',
            'service-expertise' => 'required',
            'service-icon' => 'required',
            'icon-color' => '',
            'service-id' => ''
        ];
    }
}

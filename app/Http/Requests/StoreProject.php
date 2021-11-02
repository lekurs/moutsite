<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'project-title' => 'required|max:255',
            'project-start' => 'required',
            'project-end' => 'required',
            'project-description' => 'required',
            'project-contact' => 'sometimes',
            'client-id' => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProject extends FormRequest
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
            'project-id' => 'required',
            'project-title' => 'required',
            'project_color' => '',
            'project-description-mission' => 'required',
            'project-result-mission' => 'required',

        ];
    }
}

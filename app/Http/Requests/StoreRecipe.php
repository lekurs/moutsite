<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipe extends FormRequest
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
            'recipe_label' => 'required',
            'recipe_image' => 'sometimes',
            'recipe_page_id' => 'required',
            'recipe_device_id' => 'required',
            'recipe_description' => 'required',
            'recipe_project_id' => 'required',
            'recipe_client_id' => 'required',
            'recipe_member' => 'sometimes'
        ];
    }
}

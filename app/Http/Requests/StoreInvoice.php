<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
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
            'invoice_reference' => 'required',
            'invoice_observation' => 'sometimes',
            'invoice_advance' => '',
            'invoice_advance_amount_tax' => 'sometimes',
            'invoice_advance_amount_no_tax' => 'sometimes',
            'invoice_advance_amount' => 'sometimes',
            'invoice_amount_no_tax' => 'sometimes',
            'invoice_amount' => 'sometimes',
            'invoice_amount_tax' => 'sometimes',
            'invoice_client_id' => 'required'
        ];
    }
}

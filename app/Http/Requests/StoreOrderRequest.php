<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'selectedRadioID' => 'required|integer',
            'company_id' => 'integer|nullable',
            'company_business_name' => 'string|nullable',
            'company_email' => 'required|email',
            'company_country' => 'required|string',
            'company_address' => 'required|string',
            'company_phone' => 'required|string',
            'company_vat_number' =>'string|nullable',
            'private_name' => 'string|nullable',
            'id' => 'required|array',
            'name' => 'required|array',
            'description' => 'required|array',
            'price' => 'required|array',
            'vat' => 'required|array',
            'total' => 'required|array',
            'quantity' => 'required|array',
        ];
    }
}

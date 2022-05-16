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
            'type' => 'required|string',
            'date' => 'required',
            'company_id' => 'integer|nullable',
            'business_name' => 'string|nullable',
            'email' => 'required|email',
            'country' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'vat_number' => 'string|nullable',
            'contact_name' => 'string|nullable',
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

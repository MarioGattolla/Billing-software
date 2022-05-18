<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
    public function rules()
    {
        return [
            'type' => 'required|string',
            'date' => 'required',
            'business_name' => 'string|nullable',
            'email' => 'required|email',
            'country' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'vat_number' => 'string|nullable',
            'contact_name' => 'string|nullable',

        ];
    }
}

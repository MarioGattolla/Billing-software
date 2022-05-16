<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreCompanyRequest extends FormRequest
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
            'selectedRadioID' => 'nullable',
            'business_name' => 'string|nullable',
            'vat_number' => 'string|nullable',
            'contact_name' => 'string|nullable',
            'country' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];


    }
}

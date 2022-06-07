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
            'vat_number' => 'string|nullable',
            'name' => 'string',
            'country' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required|string'
        ];


    }
}

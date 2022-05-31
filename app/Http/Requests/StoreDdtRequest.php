<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDdtRequest extends FormRequest
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
            'progressive' => 'required',
            'date' => 'required|date',
            'causal' => 'required|string',
            'selectedRadioID' => 'required|integer',
            'file' => 'required|file',
        ];
    }
}

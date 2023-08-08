<?php

namespace App\Http\Requests\Clients;

use App\Rules\CustomNidFormat;
use App\Rules\CustomPhoneFormat;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewClientRules extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'doc_customer' => ['required','string','min:5','max:15', new CustomNidFormat,'unique:clients,doc_customer'],
            'name' =>  'required|string|min:3|max:250',
            'business_address' =>  'required|string|min:10|max:250',
            'address_delivery' =>  'nullable|string|min:10|max:250',
            'email' =>  'required|email|min:7|max:50|unique:clients,email',
            'phone' => ['nullable','string','min:10','max:15', new CustomPhoneFormat],
            'state' => ['nullable','string','max:20'],
            'city' => ['nullable','string','max:20'],
            'web_customer' => ['nullable','string','max:15']
        ];
    }
}

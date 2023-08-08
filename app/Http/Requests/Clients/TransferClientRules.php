<?php

namespace App\Http\Requests\Clients;

use App\Rules\CustomBasicCharacterFormat;
use App\Rules\CustomCurrencyFormat;
use App\Rules\CustomNidFormat;
use App\Rules\CustomPhoneFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferClientRules extends FormRequest
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
            'email' =>  'required|email|min:7|max:50|unique:clients,email',
            'active' => ['nullable', 'string', 'min:1','max:1', Rule::in(['Y', 'N'])],
            'address_delivery' => 'nullable|string|min:10|max:250',
            'credit_limit' => ['nullable','numeric', new CustomCurrencyFormat],
            'state' => 'nullable|string|min:3|max:20',
            'city' => 'nullable|string|min:3|max:20',
            'phone' => ['nullable','string','min:10','max:15', new CustomPhoneFormat],
            'type_tax_1' => 'nullable|string|min:1|max:1|' . Rule::in(['0','1','2']),
            'web_customer' => 'nullable|string|max:15',
            'local_customer' => ['nullable','string','min:4','max:8', new CustomBasicCharacterFormat],
        ];
    }
}

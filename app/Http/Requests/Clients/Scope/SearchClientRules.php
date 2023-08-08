<?php

namespace App\Http\Requests\Clients\Scope;

use App\Rules\CustomApiStatusValues;
use App\Rules\CustomNidFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchClientRules extends FormRequest
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
            'active' => 'nullable|string|min:1|max:1|' . Rule::in(['Y', 'N']),
            'api-status' => ['nullable','string','min:1','max:2', new CustomApiStatusValues],
            'data-full' =>  'nullable|string|max:1|in:Y',
            'doc-customer' => ['nullable','string','min:5','max:15', new CustomNidFormat],
            'email' =>  'nullable|string|min:7|max:30',
            'name' =>  'nullable|string|min:3|max:60',
            'paginate' =>  'nullable|integer|max:200|min:5',
        ];
    }
}

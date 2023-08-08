<?php

namespace App\Http\Requests\Access\roles;

use Illuminate\Foundation\Http\FormRequest;

class SearchRoleRules extends FormRequest
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
            'paginate' =>  'nullable|integer|max:200|min:5',
        ];
    }

    public function messages()
    {
        return [
            'paginate.max' => 'El valor máximo de items por página es de 200',
            'paginate.min' => 'El valor mínimo de items por página es de 5'
        ];
    }
}

<?php

namespace App\Http\Requests\Access\Scope;

use Illuminate\Foundation\Http\FormRequest;

class SearchUserRules extends FormRequest
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
            'user-id' => 'nullable|string|max:16',
            'name' =>  'nullable|string|max:60',
            'email' =>  'nullable|string|email|max:50',
            'paginate' =>  'nullable|integer|max:200|min:5',
        ];
    }

    public function attributes()
    {
        return [
            'user-id' => 'user',
        ];
    }

    public function messages()
    {
        return [
            'user-id.max' => 'excedio el tamaño del campo para la búsqueda',
            'user-id.string' => 'el campo usuario debe ser un string',
            'name.max' => 'el string para el patrón de búsqueda no debe pasar de 20 carácteres',
            'paginate.max' => 'El valor máximo de items por página es de 200',
            'paginate.min' => 'El valor mínimo de items por página es de 5'
        ];
    }
}

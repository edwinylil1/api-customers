<?php

namespace App\Http\Requests\Access\users;

use App\Rules\CustomNidFormat;
use App\Rules\CustomPhoneFormat;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRules extends FormRequest
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
            'dni' => ['nullable','string','max:15', new CustomNidFormat],
            'name' => 'nullable|max:120|string',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'telephone' => ['nullable','string','max:15', new CustomPhoneFormat],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del cliente'
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Excedió el máximo de caracteres para el nombre, el límite es de: 120',
        ];
    }
}

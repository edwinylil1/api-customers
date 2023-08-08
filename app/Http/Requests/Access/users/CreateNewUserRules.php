<?php

namespace App\Http\Requests\Access\users;

use App\Rules\CustomNidFormat;
use App\Rules\CustomPhoneFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateNewUserRules extends FormRequest
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
            'user_id' => 'required|string|max:16|unique:users',
            'name' => 'required|max:120|string',
            'dni' => ['required','string','max:15', new CustomNidFormat],
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8|max:100|confirmed',
            'roles' => 'required|string|max:100|' . Rule::exists('roles', 'name'),
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'telephone' => ['nullable','string','max:15', new CustomPhoneFormat],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'nombre de usuario',
            'roles' => 'grupo de usuarios',
            'name' => 'nombre del cliente'
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'El nombre de usuario ya esta registrado, intente otro',
            'user_id.max' => 'Excedió el máximo de caracteres para su nombre de usuario, el límite es de: 12',
            'name.max' => 'Excedió el máximo de caracteres para el nombre, el límite es de: 120',
            'roles.required' => 'El nombre del grupo de usuarios es requerido'
        ];
    }
}

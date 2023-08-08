<?php

namespace App\Http\Requests\Access\roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRules extends FormRequest
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
            'name' => 'required|string|min:3|max:100|unique:roles',
            'permissions' => 'required|array',
            'permissions.*' => 'required|integer|min:1|'. Rule::exists('permissions', 'id'),
            'description' => 'nullable|string|max:255',
            'guard_name' => 'nullable|string|min:3|max:255|' . Rule::in(['web','api']),
        ];
    }

    /**
     * Obtiene los nombres de campos para el mensaje
     * @return array<string, mixed>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre del grupo',
            'description' => 'descripción del grupo',
            'permissions' => 'permisos',
            'guard_name' => 'nombre de guardia'
        ];
    }

    /**
     * Obtiene resultados para el mensaje
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del grupo es requerido',
            'name.min' => 'cantidad mínima de caracteres, min: 3',
            'name.max' => 'excedió el máximo de caracteres, max: 100',
            'description.max' => 'excedió el máximo de caracteres, max: 255',
            'permissions.*.integer' => 'debe mandar solamente el id del permiso para el campo array permissions',
            'permissions.*.min' => 'debe ingresar el id de un permiso existente',
            'permissions.*.exists' => 'debe ingresar un permiso existente'
        ];
    }
}

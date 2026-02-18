<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    // Reglas para crear equipo
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:teams'],
            'principal' => ['nullable', 'string', 'max:255'],
        ];
    }

    // Mensajes de error en español
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre delequipo es obligatorio.',
            'name.unique' => 'Este equipo ya existe.',
        ];
    }
}

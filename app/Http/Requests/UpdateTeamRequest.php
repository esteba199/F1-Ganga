<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    // Reglas para actualizar equipo
    public function rules(): array
    {
        $teamId = $this->route('team')->id;
        return [
            'name' => ['required', 'string', 'max:255', 'unique:teams,name,' . $teamId],
            'principal' => ['nullable', 'string', 'max:255'],
        ];
    }

    // Mensajes de error en español
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del equipo es obligatorio.',
            'name.unique' => 'Este equipo ya existe.',
        ];
    }
}

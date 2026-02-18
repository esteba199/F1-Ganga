<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    // Reglas para actualizar marca
    public function rules(): array
    {
        $brandId = $this->route('brand')->id;
        return [
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $brandId],
            'country' => ['nullable', 'string', 'max:255'],
        ];
    }

    // Mensajes de error en español
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la marca es obligatorio.',
            'name.unique' => 'Esta marca ya existe.',
        ];
    }
}

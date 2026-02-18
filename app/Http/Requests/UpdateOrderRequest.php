<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        // Solo admins pueden actualizar órdenes
        return auth()->user()?->is_admin ?? false;
    }

    // Reglas para actualizar pedido
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ];
    }

    // Mensajes de error en español
    public function messages(): array
    {
        return [
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado seleccionado no es válido.',
        ];
    }
}

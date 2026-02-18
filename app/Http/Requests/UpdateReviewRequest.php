<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        // Solo admins pueden editar reseñas
        return auth()->user()?->is_admin ?? false;
    }

    // Reglas para actualizar reseña
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ];
    }

    // Mensajes de error en español
    public function messages(): array
    {
        return [
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'car_id.required' => 'El coche es obligatorio.',
            'car_id.exists' => 'El coche seleccionado no existe.',
            'rating.required' => 'La calificación es obligatoria.',
            'rating.integer' => 'La calificación debe ser un número entero.',
            'rating.between' => 'La calificación debe estar entre 1 y 5.',
            'comment.required' => 'El comentario es obligatorio.',
            'comment.max' => 'El comentario no puede exceder 1000 caracteres.',
        ];
    }
}

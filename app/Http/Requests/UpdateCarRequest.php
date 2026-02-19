<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    // Reglas para actualizar coche
    public function rules(): array
    {
        $currentYear = date('Y');
        return [
            'model' => ['required', 'string', 'max:255'],
            'brand_id' => ['required', 'exists:brands,id'],
            'team_id' => ['required', 'exists:teams,id'],
            'year' => ['required', 'integer', 'between:1900,' . $currentYear],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'top_speed' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'acceleration' => ['nullable', 'numeric', 'min:0', 'max:99.9'],
            'engine' => ['nullable', 'string', 'max:255'],
            'horsepower' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'transmission' => ['nullable', 'string', 'max:255'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    // Solo deja si eres admin
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    // Reglas para crear coche
    public function rules(): array
    {
        $currentYear = date('Y');
        return [
            'model' => ['required', 'string', 'max:255'],
            'brand_id' => ['required', 'exists:brands,id'],
            'team_id' => ['required', 'exists:teams,id'],
            'year' => ['required', 'integer', 'between:1900,' . $currentYear],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'top_speed' => ['nullable', 'numeric'],
            'acceleration' => ['nullable', 'numeric'],
            'engine' => ['nullable', 'string'],
            'horsepower' => ['nullable', 'integer'],
            'transmission' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageService
{
    protected $accessKey;

    public function __construct()
    {
        $this->accessKey = config('services.unsplash.access_key');
    }

    /**
     * Busca una imagen en Unsplash según el nombre del coche.
     * Query: "Coche " + nombre del modelo.
     */
    public function getCarImage($modelName)
    {
        if (empty($this->accessKey)) {
            // Fallback a una imagen por defecto de F1 si no hay API Key
            return "https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=1200&h=800&fit=crop";
        }

        try {
            // Refinamos la búsqueda para que sea más específica de F1
            $response = Http::get('https://api.unsplash.com/search/photos', [
                'query' => 'Formula 1 ' . $modelName . ' racing car',
                'per_page' => 5, // Pedimos varias para elegir una al azar
                'orientation' => 'landscape',
                'client_id' => $this->accessKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data['results'])) {
                    // Seleccionar una al azar de las primeras 5 para dar variedad
                    $index = rand(0, count($data['results']) - 1);
                    return $data['results'][$index]['urls']['regular'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Error fetching image for {$modelName}: " . $e->getMessage());
        }

        return "https://images.unsplash.com/photo-1541443131876-44b03de101c5?w=1200&h=800&fit=crop"; // Una imagen de McLaren como alternativa fija
    }
}

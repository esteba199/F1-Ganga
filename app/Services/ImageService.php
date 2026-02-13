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
            $response = Http::get('https://api.unsplash.com/search/photos', [
                'query' => 'Coche ' . $modelName,
                'per_page' => 1,
                'client_id' => $this->accessKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data['results'])) {
                    return $data['results'][0]['urls']['regular'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Error fetching image for {$modelName}: " . $e->getMessage());
        }

        return "https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=1200&h=800&fit=crop";
    }
}

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

    // Busca una imagen de un coche F1 en Unsplash
    public function getCarImage($modelName)
    {
        if (empty($this->accessKey)) {
            // Si no hay API Key, pone una imagen por defecto
            return "https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=1200&h=800&fit=crop";
        }

        try {
            // Busca imágenes de F1 con el modelo
            $response = Http::get('https://api.unsplash.com/search/photos', [
                'query' => 'Formula 1 ' . $modelName . ' racing car',
                'per_page' => 5, // Pide varias para elegir una
                'orientation' => 'landscape',
                'client_id' => $this->accessKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data['results'])) {
                    // Elige una imagen al azar
                    $index = rand(0, count($data['results']) - 1);
                    return $data['results'][$index]['urls']['regular'];
                }
            }
        } catch (\Exception $e) {
            Log::error("Error fetching image for {$modelName}: " . $e->getMessage());
        }

        // Si falla, pone una imagen fija
        return "https://images.unsplash.com/photo-1541443131876-44b03de101c5?w=1200&h=800&fit=crop";
    }
}

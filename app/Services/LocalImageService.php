<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalImageService
{
    protected $disk = 'public';

    /**
     * Store uploaded image and generate a thumbnail.
     * Returns relative path that works with asset() helper.
     */
    public function store(UploadedFile $file): string
    {
        $path = $file->store('cars', $this->disk);

        // Generar miniatura de la imagen
        try {
            $this->generateThumbnail(Storage::disk($this->disk)->path($path));
        } catch (\Exception $e) {
            // Si falla la miniatura, solo seguimos
            \Illuminate\Support\Facades\Log::warning("Thumbnail generation failed: " . $e->getMessage());
        }

        // Devolver la ruta relativa de la imagen
        return '/storage/' . $path;
    }

    public function deleteByUrl(string $url): void
    {
        $base = parse_url($url, PHP_URL_PATH);
        // Quitar /storage/ si lo tiene
        $relative = preg_replace('#^/storage/#', '', $base);
        if (Storage::disk($this->disk)->exists($relative)) {
            Storage::disk($this->disk)->delete($relative);
        }
        // Borrar miniatura si existe
        $thumb = $this->thumbPath($relative);
        if (Storage::disk($this->disk)->exists($thumb)) {
            Storage::disk($this->disk)->delete($thumb);
        }
    }

    protected function generateThumbnail(string $fullPath): void
    {
        if (!extension_loaded('gd')) {
            return; // Si no hay GD, no hacemos nada
        }

        [$w, $h] = getimagesize($fullPath);
        $targetW = 300;
        $targetH = 200;

        $src = imagecreatefromstring(file_get_contents($fullPath));
        $thumb = imagecreatetruecolor($targetW, $targetH);
        imagecopyresampled($thumb, $src, 0, 0, 0, 0, $targetW, $targetH, $w, $h);

        $thumbPath = $this->thumbPath(basename($fullPath));
        $fullThumbPath = dirname($fullPath) . DIRECTORY_SEPARATOR . $thumbPath;

        imagejpeg($thumb, $fullThumbPath, 85);

        imagedestroy($src);
        imagedestroy($thumb);
    }

    protected function thumbPath(string $relative): string
    {
        $dir = dirname($relative);
        $file = basename($relative);
        return ($dir === '.') ? 'thumb_' . $file : $dir . '/thumb_' . $file;
    }
}

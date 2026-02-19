<?php

namespace App\Observers;

use App\Models\Brand;
use App\Services\TelegramService;

class BrandObserver
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function created(Brand $brand): void
    {
        $message = "🏷️ <b>¡Nueva Marca Creada!</b>\n\n";
        $message .= "📛 <b>Nombre:</b> {$brand->name}\n";
        $message .= "📅 <b>Fecha:</b> " . now()->format('d/m/Y H:i') . "\n";
        $message .= "\n✅ <i>Ya disponible para asignar a coches.</i>";

        $this->telegram->sendMessage($message);
    }
}

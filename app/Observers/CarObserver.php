<?php

namespace App\Observers;

use App\Models\Car;
use App\Services\TelegramService;

class CarObserver
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function created(Car $car): void
    {
        $car->load('brand', 'team');

        $message = "🏎️ <b>¡Nuevo Coche Publicado!</b>\n\n";
        $message .= "🚗 <b>Modelo:</b> {$car->model}\n";
        $message .= "🏷️ <b>Marca:</b> " . ($car->brand->name ?? 'Sin marca') . "\n";
        $message .= "📅 <b>Año:</b> {$car->year}\n";
        $message .= "💰 <b>Precio:</b> " . number_format($car->price, 0, ',', '.') . "€\n";
        $message .= "\n✅ <i>Disponible en el catálogo.</i>";

        $this->telegram->sendMessage($message);
    }
}

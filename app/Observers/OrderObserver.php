<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\TelegramService;

class OrderObserver
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Cargar usuario para mostrar nombre
        $order->load('user');

        $message = "🏎️ <b>¡Nueva Venta Realizada!</b>\n\n";
        $message .= "🆔 <b>Pedido:</b> #{$order->id}\n";
        $message .= "👤 <b>Cliente:</b> {$order->user->name}\n";
        $message .= "💰 <b>Total:</b> " . number_format($order->total, 2) . "€\n";
        $message .= "📅 <b>Fecha:</b> " . $order->created_at->format('d/m/Y H:i') . "\n";
        $message .= "\n🚀 <i>¡A seguir vendiendo!</i>";

        $this->telegramService->sendMessage($message);
    }
}

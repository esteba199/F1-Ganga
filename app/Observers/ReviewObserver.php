<?php

namespace App\Observers;

use App\Models\Review;
use App\Services\TelegramService;

class ReviewObserver
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function created(Review $review): void
    {
        $review->load('user', 'car');

        $stars = str_repeat('⭐', $review->rating) . str_repeat('☆', 5 - $review->rating);

        $message = "💬 <b>¡Nueva Reseña Publicada!</b>\n\n";
        $message .= "👤 <b>Usuario:</b> {$review->user->name}\n";
        $message .= "🚗 <b>Coche:</b> " . ($review->car->model ?? 'Desconocido') . "\n";
        $message .= "⭐ <b>Valoración:</b> {$stars} ({$review->rating}/5)\n";
        $message .= "📝 <b>Comentario:</b> " . \Illuminate\Support\Str::limit($review->comment, 100) . "\n";
        $message .= "📅 <b>Fecha:</b> " . now()->format('d/m/Y H:i');

        $this->telegram->sendMessage($message);
    }
}

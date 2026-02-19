<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.token');
        $this->chatId   = config('services.telegram.chat_id');
    }

    /**
     * Enviar mensaje al chat de Telegram configurado.
     *
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $message): bool
    {
        if (!$this->botToken || !$this->chatId) {
            Log::warning('TelegramService: Token o Chat ID no configurados.');
            return false;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

            $response = Http::withOptions(['verify' => false])
                ->post($url, [
                    'chat_id'    => $this->chatId,
                    'text'       => $message,
                    'parse_mode' => 'HTML',
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('TelegramService: Error al enviar mensaje.', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('TelegramService: Excepción: ' . $e->getMessage());
            return false;
        }
    }
}

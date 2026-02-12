<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Crear una nueva instancia del correo.
     * Recibe la orden confirmada.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Definir asunto y remitente.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Pedido - F1 Ganga',
        );
    }

    /**
     * Definir el contenido (vista) y datos del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmed',
            with: [
                'order' => $this->order,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

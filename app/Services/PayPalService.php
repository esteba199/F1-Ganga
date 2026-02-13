<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPalService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;

    /**
     * Constructor del servicio.
     * Inicializa las credenciales y la URL base de PayPal desde la configuración.
     */
    public function __construct()
    {
        // La URL base para la API REST de Sandbox es api-m.sandbox.paypal.com
        $this->baseUrl = config('services.paypal.base_url', 'https://api-m.sandbox.paypal.com');
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
    }

    /**
     * Obtener token de acceso (OAuth2).
     * Necesario para autenticar las solicitudes a la API de PayPal.
     */
    protected function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        return null;
    }

    /**
     * Crear una orden de pago en PayPal.
     * Define el monto, moneda y URLs de retorno/canelación.
     */
    public function createOrder($amount, $currency = 'EUR')
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => number_format($amount, 2, '.', ''),
                        ],
                    ],
                ],
                // Configuración de redirección tras el pago
                'application_context' => [
                    'return_url' => route('checkout.success'),
                    'cancel_url' => route('checkout.cancel'),
                    'brand_name' => 'F1 Ganga',
                    'user_action' => 'PAY_NOW',
                ],
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Capturar el pago de una orden previamente aprobada por el usuario.
     * Completa la transacción final.
     */
    public function captureOrder($orderId)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $response = Http::withToken($accessToken)
            ->asJson()
            ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
    /**
     * Reembolsar un pago capturado.
     * @param string $captureId ID de la captura (no el Order ID)
     * @param float|null $amount Monto a reembolsar (null para reembolso total)
     */
    public function refundOrder($captureId, $amount = null)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $payload = [];
        if ($amount) {
            $payload['amount'] = [
                'value' => number_format($amount, 2, '.', ''),
                'currency_code' => 'EUR'
            ];
        }

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/payments/captures/{$captureId}/refund", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}

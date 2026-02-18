<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PayPalService;
use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Muestra la página de checkout con el resumen del carrito.
     */
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar carrito con relaciones necesarias para mostrar detalles
        $cartItems = Cart::where('user_id', $user->id)
            ->with(['car', 'car.brand', 'car.team'])
            ->get();

        if ($cartItems->isEmpty()) {
            // Freno de mano: No dejamos pagar si no hay nada en el carrito.
            // Redirigimos al catálogo para que compre algo.
            return redirect()->route('cars.index')->with('error', 'Tu carrito está vacío.');
        }

        // Sumamos el precio de todos los items para saber cuánto cobrar al usuario.(total a pagar - importante))
        $total = $cartItems->sum(function ($item) {
            return $item->car->price * $item->quantity;
        });

        // Mostramos la vista 'checkout.index' pasando los items y el total a pagar.
        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Procesa el inicio del pago con PayPal.
     * Crea la orden en PayPal y redirige al usuario para aprobarla.
     */
    public function process()
    {
        /** @var User $user */
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('car')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cars.index');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->car->price * $item->quantity;
        });

        // Llamada a nuestro servicio de PayPal (PayPalService) para crear la intención de pago.
        // Esto contacta con la API de PayPal y nos devuelve un enlace para que el usuario apruebe.
        $orderData = $this->payPalService->createOrder($total);

        // Si PayPal nos responde bien y nos da los enlaces...
        if ($orderData && isset($orderData['links'])) {
            foreach ($orderData['links'] as $link) {
                // Buscamos el enlace 'approve', que es a donde debemos mandar al usuario para que inicie sesión en PayPal.
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('checkout.index')->with('error', 'Error al iniciar el pago con PayPal.');
    }

    /**
     * Maneja el retorno exitoso desde PayPal.
     * Captura el pago, guarda la orden en DB, limpia carrito y envía correo.
     */
    public function success(Request $request)
    {
        $token = $request->query('token');
        $payerId = $request->query('PayerID');

        if (!$token) {
            return redirect()->route('checkout.index')->with('error', 'Token de pago inválido.');
        }

        // Capturar el pago defintivamente usando el servicio
        $response = $this->payPalService->captureOrder($token);

        if ($response && isset($response['status']) && $response['status'] === 'COMPLETED') {
            
            // Usar transacción de DB para asegurar integridad de datos
            // Usar transacción de DB para asegurar integridad de datos
            return DB::transaction(function () use ($response) {
                /** @var User $user */
                $user = Auth::user();
                
                $cartItems = Cart::where('user_id', $user->id)->with('car')->get();
                
                $total = $cartItems->sum(function ($item) {
                    return $item->car->price * $item->quantity;
                });

                // 1. Guardamos la Orden principal en la tabla 'orders'
                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => $total,
                    'status' => 'paid', // ¡Importante! El estado nace como pagado
                    'payment_id' => $response['id'], // Guardamos el ID de PayPal por referencia
                ]);

                // 2. Guardamos cada item comprado en 'order_items' para tener el detalle histórico
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'car_id' => $item->car_id,
                        'quantity' => $item->quantity, 
                        'price' => $item->car->price, // Guardamos el precio al momento de la compra (por si cambia luego)
                    ]);

                    // Reducir stock del coche
                    $item->car->decrement('quantity', $item->quantity);
                }

                // 3. Registramos la transacción técnica en 'transactions' para auditoría
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'paypal_transaction_id' => $response['id'],
                    'amount' => $total,
                    'status' => 'completed',
                    'payment_method' => 'paypal',
                    'payment_details' => $response, // Guardamos TODO el JSON de PayPal por si hay disputas
                ]);

                // 4. Vaciamos el carrito porque ya se compró todo
                Cart::where('user_id', $user->id)->delete();

                // 5. Enviamos un correo bonito al usuario confirmando su compra
                Mail::to($user->email)->send(new OrderConfirmed($order));

                // Mostrar vista de éxito
                return view('checkout.success', compact('order'));
            });
        }

        return redirect()->route('checkout.index')->with('error', 'El pago no se pudo completar.');
    }

    /**
     * Maneja la cancelación del pago por parte del usuario.
     */
    public function cancel()
    {
        return redirect()->route('checkout.index')->with('info', 'El proceso de pago fue cancelado.');
    }
}

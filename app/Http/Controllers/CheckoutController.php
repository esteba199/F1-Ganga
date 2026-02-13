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
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar carrito con relaciones necesarias para mostrar detalles
        $cartItems = Cart::where('user_id', $user->id)
            ->with(['car', 'car.brand', 'car.team'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cars.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = $cartItems->sum(function ($item) {
            return $item->car->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Procesa el inicio del pago con PayPal.
     * Crea la orden en PayPal y redirige al usuario para aprobarla.
     */
    public function process()
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->with('car')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cars.index');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->car->price * $item->quantity;
        });

        // Llamada al servicio de PayPal para crear la orden
        $orderData = $this->payPalService->createOrder($total);

        // Si se crea correctamente, redirigir a la URL de aprobación
        if ($orderData && isset($orderData['links'])) {
            foreach ($orderData['links'] as $link) {
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
            return DB::transaction(function () use ($response) {
                $user = auth()->user();
                $cartItems = Cart::where('user_id', $user->id)->with('car')->get();
                
                $total = $cartItems->sum(function ($item) {
                    return $item->car->price * $item->quantity;
                });

                // 1. Crear registro de la Orden
                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => $total,
                    'status' => 'paid',
                    'payment_id' => $response['id'], // ID de transacción de PayPal
                ]);

                // 2. Crear los Items de la Orden
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'car_id' => $item->car_id,
                        'quantity' => $item->quantity, 
                        'price' => $item->car->price,
                    ]);
                }

                // 3. Registrar la Transacción (Migración de datos de PayPal)
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'paypal_transaction_id' => $response['id'],
                    'amount' => $total,
                    'status' => 'completed',
                    'payment_method' => 'paypal',
                    'payment_details' => $response, // Guardamos toda la respuesta JSON
                ]);

                // 4. Vaciar el Carrito del usuario
                Cart::where('user_id', $user->id)->delete();

                // 5. Enviar Correo de Confirmación
                Mail::to($user->email)->send(new OrderConfirmed($order));

                // Mostrar vista de éxito
                return view('checkout.success', compact('order'));
            });
        }

        return redirect()->route('checkout.index')->with('error', 'El pago no se pudo completar.');
    }

    /**
     * Procesa un pago gratuito de prueba (Demo).
     */
    public function processFree()
    {
        return DB::transaction(function () {
            $user = auth()->user();
            $cartItems = Cart::where('user_id', $user->id)->with('car')->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cars.index')->with('error', 'El carrito está vacío.');
            }

            $total = $cartItems->sum(function ($item) {
                return $item->car->price * $item->quantity;
            });

            // 1. Crear registro de la Orden
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'paid',
                'payment_id' => 'DEMO-' . uniqid(), 
            ]);

            // 2. Crear los Items de la Orden
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'car_id' => $item->car_id,
                    'quantity' => $item->quantity, 
                    'price' => $item->car->price,
                ]);
            }

            // 3. Registrar la Transacción (Demo)
            \App\Models\Transaction::create([
                'order_id' => $order->id,
                'paypal_transaction_id' => 'DEMO-' . uniqid(),
                'amount' => $total,
                'status' => 'completed',
                'payment_method' => 'free_test',
                'payment_details' => ['note' => 'Pago de prueba gratuito'],
            ]);

            // 4. Vaciar el Carrito del usuario
            Cart::where('user_id', $user->id)->delete();

            // 5. Enviar Correo de Confirmación
            // Envolver en try-catch por si mailtrap falla en demo
            try {
                Mail::to($user->email)->send(new OrderConfirmed($order));
            } catch (\Exception $e) {
                // Log error or ignore for demo
            }

            // Mostrar vista de éxito
            return view('checkout.success', compact('order'));
        });
    }

    /**
     * Maneja la cancelación del pago por parte del usuario.
     */
    public function cancel()
    {
        return redirect()->route('checkout.index')->with('info', 'El proceso de pago fue cancelado.');
    }
}

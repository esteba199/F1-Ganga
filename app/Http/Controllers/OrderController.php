<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $payPalService;

    public function __construct(\App\Services\PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Listar los pedidos del usuario autenticado.
     * Muestra el historial ordenado por fecha.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Mostrar detalle de un pedido específico.
     * Incluye validación de propiedad para seguridad.
     */
    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este pedido');
        }
        
        $order->load('items.car', 'transaction');

        return view('orders.show', compact('order'));
    }

    /**
     * Descargar factura en PDF.
     */
    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'paid' && $order->status !== 'refunded') {
            return back()->with('error', 'Solo se pueden generar facturas de pedidos pagados.');
        }

        // Usamos la librería DomPDF para generar el PDF a partir de una vista Blade.
        // 'invoices.order' es la plantilla HTML que se convertirá en PDF.
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.order', compact('order'));

        // Forzamos la descarga del archivo con un nombre personalizado.
        return $pdf->download('factura-F1Ganga-' . $order->id . '.pdf');
    }

    /**
     * Solicitar devolución del pedido.
     */
    public function refund(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'paid') {
            return back()->with('error', 'Este pedido no es elegible para devolución.');
        }

        $transaction = $order->transaction;
        if (!$transaction || !$transaction->payment_details) {
            // Sin detalles técnicos de PayPal, no podemos saber a qué ID reembolsar.
            // Esto no debería pasar si la compra se hizo bien.
            return back()->with('error', 'No se encontraron detalles de la transacción para procesar la devolución.');
        }

        // Obtener el Capture ID desde los detalles de pago guardados
        // La estructura de respuesta de captureOrder (v2) suele ser:
        // id (Order ID), status, purchase_units[0].payments.captures[0].id
        $captureId = null;
        $details = $transaction->payment_details;

        if (isset($details['purchase_units'][0]['payments']['captures'][0]['id'])) {
            $captureId = $details['purchase_units'][0]['payments']['captures'][0]['id'];
        }

        if (!$captureId) {
            return back()->with('error', 'No se pudo identificar el ID de captura de PayPal.');
        }

        // Llamamos al servicio de PayPal para ejecutar el reembolso real en su plataforma.
        $refund = $this->payPalService->refundOrder($captureId);

        if ($refund && isset($refund['status']) && $refund['status'] === 'COMPLETED') {
            
            // Actualizar estado en DB
            $order->update(['status' => 'refunded']);
            $transaction->update(['status' => 'refunded']);

            return back()->with('success', 'El reembolso se ha procesado correctamente.');
        }

        return back()->with('error', 'Error al procesar el reembolso con PayPal.');
    }
}


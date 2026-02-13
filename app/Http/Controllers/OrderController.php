<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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

        return view('orders.show', compact('order'));
    }

    /**
     * Descargar factura en PDF.
     */
    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.order', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
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
            return back()->with('error', 'Solo se pueden devolver pedidos pagados.');
        }

        // Actualizar estado del pedido
        $order->update(['status' => 'refunded']);

        // Actualizar transacción asociada si existe
        if ($order->transaction) {
            $order->transaction->update(['status' => 'refunded']);
        }

        return back()->with('success', 'Devolución procesada correctamente.');
    }
}


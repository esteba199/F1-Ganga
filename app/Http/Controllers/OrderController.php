<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Ver lista de pedidos del usuario
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Ver detalle de un pedido
    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario
        if ($order->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este pedido');
        }

        return view('orders.show', compact('order'));
    }
}

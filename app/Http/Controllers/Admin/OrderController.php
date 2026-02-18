<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    // Constructor con los middlewares de auth y admin
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Muestra la lista de pedidos con filtros
    public function index()
    {
        // Buscar por nombre de usuario o ID
        $query = Order::with(['user', 'items.car', 'transaction']);

        if ($search = request('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhere('id', $search);
        }

        // Filtrar por estado
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        // Filtrar por fechas
        if ($startDate = request('start_date')) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate = request('end_date')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $orders = $query->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    // Muestra los detalles del pedido
    public function show(Order $order)
    {
        $order->load(['user', 'items.car', 'transaction']);

        return view('admin.orders.show', compact('order'));
    }

    // Muestra el formulario para cambiar estado
    public function edit(Order $order)
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    // Actualiza el estado del pedido
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Orden actualizada correctamente.');
    }
}

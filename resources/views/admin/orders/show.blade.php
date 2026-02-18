@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-success">Pedido <span class="text-info">#{{ $order->id }}</span></h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-pencil me-2"></i>Cambiar Estado
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Atrás
            </a>
        </div>
    </div>

    <!-- Mensaje de éxito del pedido -->
    @if (session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Info del cliente -->
        <div class="col-md-6 mb-4">
            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
                    <h5 class="mb-0 text-info fw-bold"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nombre:</strong> <span class="text-white">{{ $order->user->name }}</span></p>
                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:{{ $order->user->email }}" class="text-info">{{ $order->user->email }}</a></p>
                    <p class="mb-0"><strong>Fecha:</strong> <span class="text-white-50">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Estado del pedido -->
        <div class="col-md-6 mb-4">
            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
                    <h5 class="mb-0 text-success fw-bold"><i class="bi bi-box-seam me-2"></i>Estado del Pedido</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Estado:</strong>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">Procesando</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-primary">Enviado</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Entregado</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Cancelado</span>
                        @endif
                    </p>
                    <p class="mb-0"><strong>Total:</strong> <span class="badge bg-warning text-dark fs-6">{{ number_format($order->total, 2) }}€</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de items del pedido -->
    <div class="card glass border-0 shadow-lg mb-4">
        <div class="card-header bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
            <h5 class="mb-0 text-warning fw-bold"><i class="bi bi-basket me-2"></i>Items del Pedido</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-white bg-opacity-5">
                        <tr>
                            <th class="ps-4">Coche</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-bottom border-white border-opacity-10">
                                <td class="ps-4 fw-bold">{{ $item->car->model }}</td>
                                <td><span class="badge" style="background:#fff; color:#0dcaf0; font-weight:bold; border:1px solid #0dcaf0; font-size:1rem;">{{ $item->car->brand->name }}</span></td>
                                <td>{{ number_format($item->car->price, 2) }}€</td>
                                <td><span class="badge" style="background:#fff; color:#198754; font-weight:bold; border:1px solid #198754; font-size:1rem;">{{ $item->quantity }}</span></td>
                                <td class="text-warning fw-bold">{{ number_format($item->car->price * $item->quantity, 2) }}€</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info del pago -->
    @if($order->transaction)
        <div class="card glass border-0 shadow-lg">
            <div class="card-header bg-white bg-opacity-10 border-bottom border-white border-opacity-10">
                <h5 class="mb-0 text-success fw-bold"><i class="bi bi-credit-card me-2"></i>Transacción de Pago</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Método:</strong> <span class="text-white">{{ ucfirst($order->transaction->payment_method) }}</span></p>
                <p class="mb-2"><strong>Estado:</strong>
                    <span class="badge bg-{{ $order->transaction->status == 'completed' ? 'success' : 'warning' }}">
                        {{ $order->transaction->status == 'completed' ? 'Completado' : 'Pendiente' }}
                    </span>
                </p>
                <p class="mb-2"><strong>Cantidad:</strong> <span class="text-warning fw-bold">{{ number_format($order->transaction->amount, 2) }}€</span></p>
                @if($order->transaction->paypal_transaction_id)
                    <p class="mb-0"><strong>ID PayPal:</strong> <span class="text-white-50 small">{{ $order->transaction->paypal_transaction_id }}</span></p>
                @endif
            </div>
        </div>
    @else
        <div class="alert glass border-0 border-start border-4 border-warning text-warning mb-0">
            <i class="bi bi-exclamation-triangle me-2"></i>No se encontró información de pago para este pedido.
        </div>
    @endif
</div>
@endsection

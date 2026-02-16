@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 animate__animated animate__fadeIn">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-warning"><i class="bi bi-receipt me-2"></i>Detalle del Pedido #{{ $order->id }}</h2>
                <div>
                     @if($order->status === 'paid' || $order->status === 'refunded')
                        <a href="{{ route('orders.invoice', $order) }}" class="btn btn-primary me-2"><i class="bi bi-file-earmark-pdf me-2"></i>Factura</a>
                    @endif
                    
                    @if($order->status === 'paid')
                        <form action="{{ route('orders.refund', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres solicitar la devolución de este pedido?');">
                            @csrf
                            <button type="submit" class="btn btn-danger me-2"><i class="bi bi-arrow-counterclockwise me-2"></i>Devolución</button>
                        </form>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left me-2"></i>Volver</a>
                </div>
            </div>

            <div class="card bg-dark text-white border-secondary shadow-lg">
                <div class="card-header bg-secondary bg-opacity-25 border-bottom border-secondary d-flex justify-content-between align-items-center">
                    <span>Realizado el {{ $order->created_at->format('d/m/Y H:i') }}</span>
                    @if($order->status === 'paid')
                        <span class="badge bg-success rounded-pill px-3">Pagado</span>
                    @elseif($order->status === 'pending')
                        <span class="badge bg-warning text-dark rounded-pill px-3">Pendiente</span>
                    @elseif($order->status === 'refunded')
                        <span class="badge bg-info text-dark rounded-pill px-3">Devuelto</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->car->image_url)
                                                    <img src="{{ $item->car->image_url }}" alt="{{ $item->car->model }}" class="rounded me-3" style="width: 50px; height: 30px; object-fit: cover;">
                                                @else
                                                    <div class="rounded me-3 bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 30px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                    </div>
                                                @endif
                                                <div class="{{ $order->status === 'refunded' ? 'text-decoration-line-through text-white-50' : '' }}">
                                                    <div class="fw-bold">{{ $item->car->brand->name ?? 'Marca' }} {{ $item->car->model }}</div>
                                                    <small class="text-muted">{{ $item->car->team->name ?? 'Equipo' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                                        <td class="text-end align-middle">{{ number_format($item->price, 2) }} €</td>
                                        <td class="text-end align-middle fw-bold">{{ number_format($item->price * $item->quantity, 2) }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top border-secondary">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">{{ $order->status === 'refunded' ? 'Total Reembolsado:' : 'Total Pagado:' }}</td>
                                    <td class="text-end fw-bold fs-4 {{ $order->status === 'refunded' ? 'text-info' : 'text-warning' }}">{{ number_format($order->total, 2) }} €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if($order->payment_id)
                <div class="card-footer bg-secondary bg-opacity-25 border-top border-secondary text-end">
                    <small class="text-muted">ID de Transacción PayPal: <span class="text-monospace text-white">{{ $order->payment_id }}</span></small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

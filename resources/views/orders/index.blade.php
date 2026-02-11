@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning">
            <i class="bi bi-bag-check me-2"></i>MIS PEDIDOS
        </h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="row g-4">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card glass border-0 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <small class="text-white-50 text-uppercase d-block mb-1">Pedido</small>
                                    <h6 class="text-warning mb-0">#{{ $order->id }}</h6>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <small class="text-white-50 d-block mb-1">Fecha</small>
                                    <span class="text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <small class="text-white-50 d-block mb-1">Total</small>
                                    <h5 class="text-warning mb-0">{{ number_format($order->total, 2, ',', '.') }}€</h5>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <small class="text-white-50 d-block mb-1">Estado</small>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pendiente',
                                            'processing' => 'Procesando',
                                            'completed' => 'Completado',
                                            'cancelled' => 'Cancelado'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-warning rounded-pill px-4">
                                        <i class="bi bi-eye me-2"></i>Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="card glass border-0 shadow-lg p-5 mx-auto animate__animated animate__bounceIn" style="max-width: 600px;">
                <i class="bi bi-bag-x display-1 text-warning opacity-25 mb-4"></i>
                <h3 class="text-white mb-3">Aún no tienes pedidos</h3>
                <p class="text-white-50 mb-4">¡Explora nuestro increíble catálogo de coches F1 y haz tu primera compra!</p>
                <a href="{{ route('cars.index') }}" class="btn btn-warning fw-bold px-5 py-3 rounded-pill">
                    <i class="bi bi-search me-2"></i>Explorar Catálogo
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container fade-in-subtle">
    <div class="container mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-2 mb-2">
            <i class="bi bi-speedometer2 me-2"></i>MI PANEL
        </h1>
        <p class="text-white-50 lead">Bienvenido de nuevo, <strong>{{ Auth::user()->name }}</strong></p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card glass border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 small mb-1">Mis Pedidos</p>
                            <h3 class="text-warning fw-bold mb-0">{{ Auth::user()->orders->count() }}</h3>
                        </div>
                        <i class="bi bi-cart-check display-4 text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card glass border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 small mb-1">Mis Reseñas</p>
                            <h3 class="text-warning fw-bold mb-0">{{ Auth::user()->reviews->count() }}</h3>
                        </div>
                        <i class="bi bi-star-fill display-4 text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card glass border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 small mb-1">Cuenta desde</p>
                            <h6 class="text-warning fw-bold mb-0">{{ Auth::user()->created_at->format('M Y') }}</h6>
                        </div>
                        <i class="bi bi-calendar-check display-4 text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('cars.index') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-search me-2"></i>Explorar Catálogo
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-light w-100 py-3">
                                <i class="bi bi-person-gear me-2"></i>Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-6 mb-4">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bi bi-bag-check me-2"></i>Pedidos Recientes
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(Auth::user()->orders->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach(Auth::user()->orders()->latest()->take(3)->get() as $order)
                                <div class="list-group-item bg-transparent border-white border-opacity-10 px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 text-warning">Pedido #{{ $order->id }}</h6>
                                            <small class="text-white-50">{{ $order->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($order->status === 'refunded')
                                            <span class="badge bg-info text-dark">Reembolsado</span>
                                        @else
                                            <span class="badge bg-success">{{ number_format($order->total, 2) }}€</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-warning">Ver Todos</a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-bag-x display-1 text-warning opacity-25 mb-3"></i>
                            <p class="text-white-50 mb-0">No tienes pedidos aún</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-lg-6 mb-4">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bi bi-chat-quote me-2"></i>Mis Reseñas
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(Auth::user()->reviews->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach(Auth::user()->reviews()->latest()->take(3)->get() as $review)
                                <div class="list-group-item bg-transparent border-white border-opacity-10 px-0">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">{{ $review->car->model }}</h6>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }} small"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-white-50 small mb-1">{{ Str::limit($review->comment, 50) }}</p>
                                    <small class="text-white-50">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-chat-dots display-1 text-warning opacity-25 mb-3"></i>
                            <p class="text-white-50 mb-0">No has dejado reseñas aún</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

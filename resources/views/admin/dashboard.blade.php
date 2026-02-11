@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning">
            <i class="bi bi-shield-check me-2"></i>PANEL DE ADMIN
        </h1>
        <a href="{{ route('cars.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Catálogo
        </a>
    </div>

    <!-- Main Stats Grid -->
    <div class="row g-4 mb-5">
        <!-- Total Cars -->
        <div class="col-md-3">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning small text-uppercase fw-bold mb-1">Coches</div>
                            <div class="h2 fw-bold mb-0">{{ $stats['total_cars'] }}</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-car-front fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-3">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-info small text-uppercase fw-bold mb-1">Usuarios</div>
                            <div class="h2 fw-bold mb-0">{{ $stats['total_users'] }}</div>
                            @if($stats['new_users_week'] > 0)
                                <small class="text-success">+{{ $stats['new_users_week'] }} esta semana</small>
                            @endif
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-people fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-success small text-uppercase fw-bold mb-1">Pedidos</div>
                            <div class="h2 fw-bold mb-0">{{ $stats['total_orders'] }}</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cart-check fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning small text-uppercase fw-bold mb-1">Ingresos</div>
                            <div class="h3 fw-bold mb-0">{{ number_format($stats['total_revenue'], 0, ',', '.') }}€</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cash-stack fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card glass border-0 shadow-lg">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-chat-dots fs-1 text-warning mb-2"></i>
                    <h3 class="fw-bold mb-1">{{ $stats['total_reviews'] }}</h3>
                    <p class="text-white-50 small mb-0">
                        Reseñas Totales
                        @if($stats['pending_reviews'] > 0)
                            <span class="badge bg-danger ms-2">{{ $stats['pending_reviews'] }} nuevas</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card glass border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('cars.create') }}" class="btn btn-warning text-dark fw-bold px-4 rounded-pill">
                            <i class="bi bi-plus-lg me-2"></i>Añadir Coche
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-warning fw-bold px-4 rounded-pill">
                            <i class="bi bi-chat-dots me-2"></i>Moderar Reseñas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Sections -->
    <div class="row g-4">
        <!-- Recent Cars -->
        <div class="col-lg-4">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 text-warning fw-bold">
                        <i class="bi bi-car-front me-2"></i>Coches Recientes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentCars as $car)
                            <div class="list-group-item bg-transparent border-white border-opacity-10 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($car->image_url)
                                        <img src="{{ $car->image_url }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $car->model }}">
                                    @else
                                        <div class="bg-white bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-car-front text-warning"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 text-warning">{{ $car->model }}</h6>
                                        <small class="text-white-50">{{ $car->brand->name }} • {{ number_format($car->price, 0) }}€</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-white-50">
                                <i class="bi bi-car-front display-4 opacity-25 mb-2"></i>
                                <p class="mb-0">No hay coches recientes</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-lg-4">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 text-success fw-bold">
                        <i class="bi bi-cart-check me-2"></i>Pedidos Recientes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentOrders as $order)
                            <div class="list-group-item bg-transparent border-white border-opacity-10 px-4 py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-white">{{ $order->user->name }}</h6>
                                        <small class="text-white-50">{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-success fw-bold">{{ number_format($order->total, 2) }}€</div>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }} badge-sm">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-white-50">
                                <i class="bi bi-cart-x display-4 opacity-25 mb-2"></i>
                                <p class="mb-0">No hay pedidos recientes</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-lg-4">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-warning fw-bold">
                            <i class="bi bi-chat-quote me-2"></i>Reseñas Recientes
                        </h5>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-warning">
                            Ver todas
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentReviews as $review)
                            <div class="list-group-item bg-transparent border-white border-opacity-10 px-4 py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-white">{{ $review->user->name }}</h6>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }} small"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-white-50 small mb-1">{{ Str::limit($review->comment, 60) }}</p>
                                <small class="text-warning">{{ $review->car->model }}</small>
                            </div>
                        @empty
                            <div class="text-center py-5 text-white-50">
                                <i class="bi bi-chat-dots display-4 opacity-25 mb-2"></i>
                                <p class="mb-0">No hay reseñas recientes</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

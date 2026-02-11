@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Admin Dashboard') }}</h1>

    <div class="row">
        <!-- Cars Stat -->
        <div class="col-md-3 mb-4">
            <div class="card glass border-0 text-white shadow-lg h-100 animate__animated animate__zoomIn">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning small text-uppercase fw-bold letter-spacing-1">{{ __('Coches') }}</div>
                            <div class="fs-2 fw-bold">{{ $stats['total_cars'] }}</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-car-front fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Stat -->
        <div class="col-md-3 mb-4">
            <div class="card glass border-0 text-white shadow-lg h-100 animate__animated animate__zoomIn" style="animation-delay: 0.1s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-info small text-uppercase fw-bold letter-spacing-1">{{ __('Usuarios') }}</div>
                            <div class="fs-2 fw-bold">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-people fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Stat -->
        <div class="col-md-3 mb-4">
            <div class="card glass border-0 text-white shadow-lg h-100 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-success small text-uppercase fw-bold letter-spacing-1">{{ __('Pedidos') }}</div>
                            <div class="fs-2 fw-bold">{{ $stats['total_orders'] }}</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cart fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Stat -->
        <div class="col-md-3 mb-4">
            <div class="card glass border-0 text-white shadow-lg h-100 animate__animated animate__zoomIn" style="animation-delay: 0.3s;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-danger small text-uppercase fw-bold letter-spacing-1">{{ __('Reseñas') }}</div>
                            <div class="fs-2 fw-bold">{{ $stats['total_reviews'] }}</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-star fs-2 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card glass border-0 shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge me-2 text-warning"></i>{{ __('Acciones Rápidas') }}</h5>
                </div>
                <div class="card-body py-4 text-center">
                    <div class="btn-group gap-3" role="group">
                        <a href="{{ route('cars.create') }}" class="btn btn-warning text-dark fw-bold px-4 rounded-pill">
                            <i class="bi bi-plus-lg me-1"></i>Añadir Coche
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-light fw-bold px-4 rounded-pill">
                            <i class="bi bi-chat-dots me-1"></i>Moderar Reseñas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Orders -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Últimos Pedidos') }}</h5>
                    <a href="#" class="btn btn-sm btn-link p-0 text-decoration-none text-success">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ number_format($order->total, 2) }}€</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No hay pedidos recientes.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Últimas Reseñas') }}</h5>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none text-warning">Moderar</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Coche</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ $review->car->model }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }} small"></i>
                                        @endfor
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No hay reseñas recientes.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

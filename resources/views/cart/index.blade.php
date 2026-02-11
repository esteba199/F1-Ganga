@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning">
            <i class="bi bi-cart3 me-2"></i>MI CARRITO
        </h1>
        @if($cartItems->count() > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('¿Vaciar todo el carrito?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-trash me-2"></i>Vaciar Carrito
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4 animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                @foreach($cartItems as $item)
                    <div class="card glass border-0 shadow-lg mb-3 animate__animated animate__fadeInUp">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    @if($item->car->image_url)
                                        <img src="{{ $item->car->image_url }}" class="img-fluid rounded" alt="{{ $item->car->model }}">
                                    @else
                                        <i class="bi bi-car-front display-4 text-warning opacity-25"></i>
                                    @endif
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <h5 class="mb-1 text-warning">{{ $item->car->model }}</h5>
                                    <p class="text-white-50 small mb-0">
                                        <i class="bi bi-building me-1"></i>{{ $item->car->brand->name }} |
                                        <i class="bi bi-flag ms-2 me-1"></i>{{ $item->car->team->name }}
                                    </p>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0">
                                    <form action="{{ route('cart.update', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-outline-warning" onclick="this.parentElement.querySelector('input').stepDown(); this.form.submit();">-</button>
                                            <input type="number" name="quantity" class="form-control text-center" value="{{ $item->quantity }}" min="1" max="10" style="max-width: 60px;">
                                            <button type="button" class="btn btn-outline-warning" onclick="this.parentElement.querySelector('input').stepUp(); this.form.submit();">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 text-md-end mb-3 mb-md-0">
                                    <p class="text-white-50 small mb-1">Precio unitario</p>
                                    <h5 class="text-warning mb-0">{{ number_format($item->car->price, 0, ',', '.') }}€</h5>
                                    @if($item->quantity > 1)
                                        <small class="text-white-50">Total: {{ number_format($item->car->price * $item->quantity, 0, ',', '.') }}€</small>
                                    @endif
                                </div>
                                <div class="col-md-1 text-end">
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="col-lg-4">
                <div class="card glass border-0 shadow-lg sticky-top" style="top: 100px;">
                    <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-3">
                        <h5 class="mb-0 text-warning fw-bold">
                            <i class="bi bi-receipt me-2"></i>Resumen del Pedido
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Productos ({{ $cartItems->count() }})</span>
                            <span class="text-white">{{ number_format($total, 2, ',', '.') }}€</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Envío</span>
                            <span class="text-success">GRATIS</span>
                        </div>
                        <hr class="border-white border-opacity-10 my-3">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 text-warning mb-0">TOTAL</span>
                            <span class="h4 text-warning mb-0 fw-bold">{{ number_format($total, 2, ',', '.') }}€</span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-warning btn-lg fw-bold text-dark">
                                <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                            </a>
                            <a href="{{ route('cars.index') }}" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="card glass border-0 shadow-lg p-5 mx-auto animate__animated animate__fadeIn" style="max-width: 600px;">
                <i class="bi bi-cart-x display-1 text-warning opacity-25 mb-4"></i>
                <h3 class="text-white mb-3">Tu carrito está vacío</h3>
                <p class="text-white-50 mb-4">¡Explora nuestro catálogo y encuentra tu F1 perfecto!</p>
                <a href="{{ route('cars.index') }}" class="btn btn-warning fw-bold px-5">
                    <i class="bi bi-search me-2"></i>Explorar Catálogo
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

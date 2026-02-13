@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="container mb-5 px-0">
        <h1 class="display-5 fw-bold text-warning letter-spacing-2 mb-2">
            <i class="bi bi-credit-card-2-front me-2"></i>FINALIZAR COMPRA
        </h1>
        <p class="text-white-50 lead">Completa tu pedido de forma segura.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('error'))
                <div class="alert alert-danger shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info shadow-sm">
                    <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
                </div>
            @endif

            <div class="card bg-dark text-white border-secondary shadow-lg">
                <div class="card-header bg-secondary bg-opacity-25 border-bottom border-secondary">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Coche</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
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
                                                <div>
                                                    <div class="fw-bold">{{ $item->car->brand->name ?? 'Marca' }} {{ $item->car->model }}</div>
                                                    <small class="text-muted">{{ $item->car->team->name ?? 'Equipo' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                                        <td class="text-end align-middle">{{ number_format($item->car->price, 2) }} €</td>
                                        <td class="text-end align-middle fw-bold">{{ number_format($item->car->price * $item->quantity, 2) }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top border-secondary">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Total a Pagar:</td>
                                    <td class="text-end fw-bold fs-4 text-warning">{{ number_format($total, 2) }} €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-secondary bg-opacity-25 border-top border-secondary p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Carrito
                        </a>
                        
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg fw-bold shadow">
                                <i class="bi bi-paypal me-2"></i>Pagar con PayPal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

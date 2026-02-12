@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center animate__animated animate__fadeIn">
            <div class="card bg-dark text-white border-success shadow-lg">
                <div class="card-header bg-success text-white border-bottom border-success">
                    <h3 class="mb-0"><i class="bi bi-check-circle-fill me-2"></i>¡Pago Completado!</h3>
                </div>
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h4 class="fw-bold mb-3 text-success">Tu orden ha sido procesada con éxito.</h4>
                    
                    <p class="lead">Gracias por comprar en F1 Ganga. Hemos enviado un correo de confirmación a tu dirección de email.</p>
                    
                    <hr class="border-secondary my-4">
                    
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6 text-start">
                            <p class="mb-1"><strong class="text-warning">Número de Orden:</strong> #{{ $order->id }}</p>
                            <p class="mb-1"><strong class="text-warning">Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-0"><strong class="text-warning">Total Pagado:</strong> {{ number_format($order->total, 2) }} €</p>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg fw-bold shadow">
                            <i class="bi bi-list-check me-2"></i>Ver mis Pedidos
                        </a>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-light btn-lg fw-bold">
                            <i class="bi bi-cart-plus me-2"></i>Seguir Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

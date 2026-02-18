@extends('layouts.app')

@section('content')
<style>
    select.form-select, select.form-select option {
        color: #000 !important;
        background-color: #fff !important;
    }
    select.form-select option:checked {
        background: linear-gradient(#198754, #198754) !important;
        background-color: #198754 !important;
        color: white !important;
    }
    .form-control, .form-control::placeholder {
        color: #000 !important;
        background-color: #fff !important;
    }
    .form-control::placeholder {
        color: #999 !important;
    }
    .badge-order-status {
        background: #fff !important;
        font-weight: bold;
        font-size: 1rem;
        border: 1.5px solid #ccc;
        padding: 0.5em 1em;
        letter-spacing: 0.5px;
        box-shadow: 0 1px 4px #0001;
    }
    .badge-pending { color: #ffc107 !important; border-color: #ffc107 !important; }
    .badge-processing { color: #0dcaf0 !important; border-color: #0dcaf0 !important; }
    .badge-shipped { color: #0d6efd !important; border-color: #0d6efd !important; }
    .badge-delivered { color: #198754 !important; border-color: #198754 !important; }
    .badge-cancelled { color: #dc3545 !important; border-color: #dc3545 !important; }
</style>
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-success">Cambiar Estado - Pedido <span class="text-info">#{{ $order->id }}</span></h1>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Atrás
        </a>
    </div>

    <!-- Aquí va el formulario para cambiar el estado del pedido -->
    <div class="card glass border-0 shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status" class="form-label text-white fw-bold">Estado del Pedido <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Selecciona un estado --</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                @switch($status)
                                    @case('pending')
                                        Pendiente
                                        @break
                                    @case('processing')
                                        Procesando
                                        @break
                                    @case('shipped')
                                        Enviado
                                        @break
                                    @case('delivered')
                                        Entregado
                                        @break
                                    @case('cancelled')
                                        Cancelado
                                        @break
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="p-3 rounded mb-4" style="background: #fff; box-shadow: 0 2px 8px #0001;">
                    <p class="mb-0 fw-bold text-dark small"><i class="bi bi-info-circle me-2 text-info"></i>Estado actual: 
                        @switch($order->status)
                            @case('pending')
                                <span class="badge badge-order-status badge-pending">Pendiente</span>
                                @break
                            @case('processing')
                                <span class="badge badge-order-status badge-processing">Procesando</span>
                                @break
                            @case('shipped')
                                <span class="badge badge-order-status badge-shipped">Enviado</span>
                                @break
                            @case('delivered')
                                <span class="badge badge-order-status badge-delivered">Entregado</span>
                                @break
                            @case('cancelled')
                                <span class="badge badge-order-status badge-cancelled">Cancelado</span>
                                @break
                        @endswitch
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success fw-bold px-5 rounded-pill">
                        <i class="bi bi-check-circle me-2"></i>Actualizar Estado
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-light rounded-pill px-5">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
    .badge-payment-success { color: #198754 !important; border-color: #198754 !important; background: #fff !important; }
    .badge-payment-pending { color: #ffc107 !important; border-color: #ffc107 !important; background: #fff !important; }
</style>
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-success letter-spacing-1">GESTIÓN DE <span class="text-white">PEDIDOS</span></h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Filtros para buscar pedidos -->
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por usuario o ID...">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">-- Todos los estados --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-light w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de pedidos -->
    <div class="card glass border-0 shadow-lg overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-white bg-opacity-10">
                    <thead class="bg-white bg-opacity-10">
                        <tr>
                            <th class="ps-4 py-3">Pedido</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Items</th>
                            <th>Estado</th>
                            <th>Pago</th>
                            <th>Fecha</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($orders as $order)
                        <tr class="border-bottom border-white border-opacity-10">
                            <td class="ps-4 fw-bold text-success">#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td><span class="badge badge-order-status badge-pending">{{ number_format($order->total, 2) }}€</span></td>
                            <td><span class="badge badge-order-status badge-processing">{{ $order->items->count() }} items</span></td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge badge-order-status badge-pending">Pendiente</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge badge-order-status badge-processing">Procesando</span>
                                @elseif($order->status == 'shipped')
                                    <span class="badge badge-order-status badge-shipped">Enviado</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge badge-order-status badge-delivered">Entregado</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-order-status badge-cancelled">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                @if($order->transaction)
                                    @if($order->transaction->status == 'completed')
                                        <span class="badge badge-order-status badge-payment-success">Completado</span>
                                    @else
                                        <span class="badge badge-order-status badge-payment-pending">Pendiente</span>
                                    @endif
                                @else
                                    <span class="text-white-50 small">-</span>
                                @endif
                            </td>
                            <td class="text-white-50 small">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info rounded-pill px-3 me-2">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-white-50">
                                <i class="bi bi-inbox display-4 opacity-25 mb-2 d-block"></i>
                                <p class="mb-0">No hay pedidos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top border-white border-opacity-10 py-3">
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

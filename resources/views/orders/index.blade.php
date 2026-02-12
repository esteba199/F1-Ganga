@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 animate__animated animate__fadeInUp">
            <h2 class="mb-4 fw-bold text-warning"><i class="bi bi-clock-history me-2"></i>Historial de Pedidos</h2>

            @if($orders->isEmpty())
                <div class="card bg-dark text-white border-secondary shadow-lg">
                    <div class="card-body p-5 text-center">
                        <i class="bi bi-inbox text-secondary" style="font-size: 3rem;"></i>
                        <p class="h5 mt-3 text-muted">Aún no has realizado pedidos.</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-warning mt-3 fw-bold">Ir al Catálogo</a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover rounded shadow-lg overflow-hidden border border-secondary">
                        <thead class="bg-gradient-secondary text-white">
                            <tr>
                                <th># Orden</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="align-middle fw-bold text-warning">#{{ $order->id }}</td>
                                    <td class="align-middle text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle">
                                        @if($order->status === 'paid')
                                            <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check-circle-fill me-1"></i>Pagado</span>
                                        @elseif($order->status === 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3"><i class="bi bi-hourglass-split me-1"></i>Pendiente</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger rounded-pill px-3"><i class="bi bi-x-circle-fill me-1"></i>Cancelado</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle fw-bold fs-5">{{ number_format($order->total, 2) }} €</td>
                                    <td class="align-middle">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links('pagination::bootstrap-5') }}     
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

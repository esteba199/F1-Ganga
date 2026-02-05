@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('Admin Dashboard') }}</h1>

    <div class="row">
        <!-- Cars Stat -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">{{ __('Coches') }}</div>
                            <div class="fs-4 fw-bold">{{ $stats['total_cars'] }}</div>
                        </div>
                        <i class="bi bi-car-front fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Stat -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">{{ __('Usuarios') }}</div>
                            <div class="fs- fs-4 fw-bold">{{ $stats['total_users'] }}</div>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Stat -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">{{ __('Pedidos') }}</div>
                            <div class="fs-4 fw-bold">{{ $stats['total_orders'] }}</div>
                        </div>
                        <i class="bi bi-cart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Stat -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small text-uppercase fw-bold">{{ __('Reseñas') }}</div>
                            <div class="fs-4 fw-bold">{{ $stats['total_reviews'] }}</div>
                        </div>
                        <i class="bi bi-star fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ __('Gestión Rápida') }}</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('cars.create') }}" class="btn btn-outline-primary">Añadir Coche</a>
                        <a href="#" class="btn btn-outline-success">Ver Pedidos</a>
                        <a href="#" class="btn btn-outline-warning">Moderar Reseñas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

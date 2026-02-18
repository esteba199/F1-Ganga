@extends('layouts.app')

@section('content')
<style>
    select.form-select, select.form-select option {
        color: #000 !important;
        background-color: #fff !important;
    }
    select.form-select option:checked {
        background: linear-gradient(#ffc107, #ffc107) !important;
        background-color: #ffc107 !important;
        color: black !important;
    }
    .table.glass-table {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(10px) !important;
    }
    .table.glass-table thead {
        background: rgba(201, 161, 59, 0.3) !important;
        border-bottom: 2px solid rgba(255, 255, 255, 0.3) !important;
    }
    .table.glass-table thead th {
        color: #fff !important;
        font-weight: bold !important;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5) !important;
    }
    .table.glass-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    }
    .table.glass-table tbody td {
        color: #fff !important;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3) !important;
        vertical-align: middle !important;
    }
    .table.glass-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.15) !important;
    }
    .table.glass-table tbody tr.table-warning {
        background: rgba(255, 193, 7, 0.2) !important;
    }
    .card.glass {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 15px !important;
    }
</style>

<div class="container animate__animated animate__fadeIn">
    <div class="card glass p-4 mb-4">
        <h1 class="display-5 fw-bold text-warning mb-0">
            <i class="bi bi-car-front-fill"></i> Gestión de Coches
        </h1>
    </div>

    <!-- Filtros para buscar coches -->
    <div class="card glass p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-white fw-bold mb-0">Filtros y Búsqueda</h5>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-warning rounded-pill">
                <i class="bi bi-plus-circle"></i> Nuevo Coche
            </a>
        </div>
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold text-white">Marca</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Todas las Marcas --</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-white">Equipo</label>
                    <select name="team_id" class="form-select">
                        <option value="">-- Todos los Equipos --</option>
                        @foreach($teams as $t)
                            <option value="{{ $t->id }}" {{ request('team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-white">Modelo</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por modelo...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-warning rounded-pill w-100">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de coches -->
    <div class="card glass p-4">
        <div class="table-responsive">
            <table class="table glass-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 10%">Imagen</th>
                        <th style="width: 15%">Modelo</th>
                        <th style="width: 15%">Marca</th>
                        <th style="width: 15%">Equipo</th>
                        <th style="width: 12%">Precio</th>
                        <th style="width: 28%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                        <tr @if($car->trashed()) class="table-warning" @endif>
                            <td>{{ $car->id }}</td>
                            <td style="width:120px">
                                @if($car->image_url)
                                    <img src="{{ asset($car->image_url) }}" alt="{{ $car->model }}" class="img-fluid rounded-2" style="max-height:60px; object-fit:cover;">
                                @else
                                    <span class="text-muted"><i class="bi bi-image"></i> Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->brand->name ?? '-' }}</td>
                            <td>{{ $car->team->name ?? '-' }}</td>
                            <td>${{ number_format($car->price, 2) }}</td>
                            <td>
                                @if($car->trashed())
                                    <form action="{{ route('admin.cars.restore', $car->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                            <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.cars.forceDelete', $car->id) }}" method="POST" style="display:inline" onclick="return confirm('¿Eliminar permanentemente?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                            <i class="bi bi-trash"></i> Borrar
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-primary rounded-pill">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" style="display:inline" onclick="return confirm('¿Eliminar este coche?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-white py-4">
                                <i class="bi bi-inbox"></i> No hay coches registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection

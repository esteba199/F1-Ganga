@extends('layouts.app')

@section('content')
<style>
    .table.glass-table {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(10px) !important;
    }
    .table.glass-table thead {
        background: rgba(13, 202, 240, 0.3) !important;
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
    .form-control, .form-control::placeholder {
        color: #000 !important;
        background-color: #fff !important;
    }
    .form-control::placeholder {
        color: #999 !important;
    }
    select.form-select, select.form-select option {
        color: #000 !important;
        background-color: #fff !important;
    }
    select.form-select option:checked {
        background: linear-gradient(#0dcaf0, #0dcaf0) !important;
        background-color: #0dcaf0 !important;
        color: white !important;
    }
</style>

<div class="container animate__animated animate__fadeIn">
    <div class="card glass p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="display-5 fw-bold text-info mb-0">
                <i class="bi bi-diagram-3"></i> Gestión de Marcas
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.brands.create') }}" class="btn btn-info rounded-pill px-4 fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Nueva Marca
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i>Dashboard
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Filtro para buscar marcas -->
    <div class="card glass p-4 mb-4">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold text-white">Búsqueda</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar marca o país...">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-info rounded-pill w-100">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de marcas -->
    <div class="card glass border-0 shadow-lg overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table glass-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th>Nombre</th>
                            <th>País</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($brands as $brand)
                        <tr>
                            <td class="ps-4 fw-bold text-info">{{ $brand->id }}</td>
                            <td class="fw-bold">{{ $brand->name }}</td>
                            <td><span class="badge bg-info bg-opacity-20 text-info">{{ $brand->country ?? '-' }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-white">
                                <i class="bi bi-inbox display-4 mb-2 d-block opacity-50"></i>
                                <p class="mb-0">No hay marcas registradas</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top border-white border-opacity-10 py-3">
            <div class="d-flex justify-content-center">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

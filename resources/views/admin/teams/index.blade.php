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
</style>
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-success letter-spacing-1">GESTIÓN DE <span class="text-white">EQUIPOS</span></h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.teams.create') }}" class="btn btn-success rounded-pill px-4 fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Nuevo Equipo
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Filtro para buscar equipos -->
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar equipo o director...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-light w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de equipos -->
    <div class="card glass border-0 shadow-lg overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-white bg-opacity-10">
                    <thead class="bg-white bg-opacity-10">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th>Nombre</th>
                            <th>Director / Principal</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($teams as $team)
                        <tr class="border-bottom border-white border-opacity-10">
                            <td class="ps-4 fw-bold text-success">{{ $team->id }}</td>
                            <td class="fw-bold">{{ $team->name }}</td>
                            <td>
                                <span class="badge" style="background: #fff; color: #198754; font-weight: bold; border: 1px solid #198754; font-size: 1rem;">
                                    {{ $team->principal ?? '-' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-white-50">
                                <i class="bi bi-inbox display-4 opacity-25 mb-2 d-block"></i>
                                <p class="mb-0">No hay equipos registrados</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top border-white border-opacity-10 py-3">
            <div class="d-flex justify-content-center">
                {{ $teams->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

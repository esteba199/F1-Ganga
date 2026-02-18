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
        color: #000 !important;
    }
    .form-control, .form-control::placeholder {
        color: #000 !important;
        background-color: #fff !important;
    }
    .form-control::placeholder {
        color: #999 !important;
    }
    .badge-car {
        background: #fff !important;
        color: #ffc107 !important;
        font-weight: bold;
        border: 1px solid #ffc107;
        font-size: 1rem;
    }
    .star-rating {
        font-size: 1.1rem;
        color: #ffc107 !important;
        filter: drop-shadow(0 0 2px #0008);
    }
</style>
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-1">MODERACIÓN DE <span class="text-white">RESEÑAS</span></h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-warning rounded-pill px-4 fw-bold">
                <i class="bi bi-plus-lg me-2"></i>Nueva Reseña
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

    <!-- Filtros para buscar reseñas -->
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar usuario o comentario...">
            </div>
            <div class="col-md-3">
                <select name="car_id" class="form-select">
                    <option value="">-- Todos los coches --</option>
                    @foreach($cars as $id => $model)
                        <option value="{{ $id }}" {{ request('car_id') == $id ? 'selected' : '' }}>{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="rating" class="form-select">
                    <option value="">-- Todas las calificaciones --</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-light w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="card glass border-0 shadow-lg overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-white bg-opacity-10">
                        <tr>
                            <th class="ps-4 py-3">Fecha</th>
                            <th>Usuario</th>
                            <th>Coche</th>
                            <th>Puntuación</th>
                            <th>Comentario</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($reviews as $review)
                        <tr class="border-bottom border-white border-opacity-10">
                            <td class="ps-4 text-white-50 small">{{ $review->created_at->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $review->user->name }}</td>
                            <td><span class="badge badge-car">{{ $review->car->model }}</span></td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill star-rating' : '' }} small"></i>
                                @endfor
                            </td>
                            <td>
                                <small class="text-white-50">{{ Str::limit($review->comment, 60) }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top border-white border-opacity-10 py-3">
            <div class="d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

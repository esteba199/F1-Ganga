@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-1">MODERACIÓN DE <span class="text-white">RESEÑAS</span></h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

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
                            <td><span class="badge bg-white bg-opacity-10 text-warning">{{ $review->car->model }}</span></td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }} small"></i>
                                @endfor
                            </td>
                            <td>
                                <small class="text-white-50">{{ Str::limit($review->comment, 60) }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta reseña?')">
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

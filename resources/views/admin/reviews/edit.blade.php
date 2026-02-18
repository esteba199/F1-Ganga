@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning">Editar Reseña</h1>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Atrás
        </a>
    </div>

    <div class="card glass border-0 shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('admin.reviews.update', $review) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('admin.reviews._form')
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning fw-bold px-5 rounded-pill text-dark">
                        <i class="bi bi-check-circle me-2"></i>Actualizar Reseña
                    </button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-light rounded-pill px-5">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

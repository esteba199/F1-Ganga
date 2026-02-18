@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-info">Editar Marca</h1>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Atrás
        </a>
    </div>

    <div class="card glass border-0 shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('admin.brands._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-info fw-bold px-5 rounded-pill">
                        <i class="bi bi-check-circle me-2"></i>Actualizar Marca
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light rounded-pill px-5">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-success">Crear Nuevo Equipo</h1>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Atrás
        </a>
    </div>

    <div class="card glass border-0 shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('admin.teams.store') }}" method="POST" novalidate>
                @csrf
                @include('admin.teams._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success fw-bold px-5 rounded-pill">
                        <i class="bi bi-check-circle me-2"></i>Guardar Equipo
                    </button>
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-light rounded-pill px-5">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

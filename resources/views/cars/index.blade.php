@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-4 fw-bold text-warning letter-spacing-2">CATÁLOGO F1</h1>
        @auth
            <a href="{{ route('cars.create') }}" class="btn btn-warning fw-bold px-4 rounded-pill shadow-lg">
                <i class="bi bi-plus-lg me-1"></i> PUBLICAR COCHE
            </a>
        @else
            <button class="btn btn-outline-light fw-bold px-4 rounded-pill" onclick="window.location.href='{{ route('login') }}'">
                <i class="bi bi-lock me-1"></i> Acceder para Publicar
            </button>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4 animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($cars->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 animate__animated animate__fadeInUp">
            @foreach($cars as $car)
                <div class="col">
                    <div class="card h-100 border-0 shadow-lg position-relative overflow-hidden">
                        <div class="position-relative" style="height: 200px; background: linear-gradient(135deg, #1a1e23 0%, #2d3436 100%);">
                            @if($car->image_url)
                                <img src="{{ $car->image_url }}" class="w-100 h-100 object-fit-cover" alt="{{ $car->model }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-car-front display-1 text-warning opacity-25"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-uppercase fw-bold letter-spacing-1 py-2 px-3">En Venta</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="card-title fw-bold mb-0">{{ $car->model }}</h4>
                                <span class="text-warning fw-bold fs-5">{{ number_format($car->price, 0, ',', '.') }}€</span>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-white bg-opacity-10 me-2"><i class="bi bi-calendar me-1"></i>{{ $car->year }}</span>
                                <span class="badge bg-white bg-opacity-10 me-2"><i class="bi bi-speedometer2 me-1"></i>{{ $car->team->name }}</span>
                            </div>
                            <p class="text-white-50 small mb-4">{{ Str::limit($car->description ?? 'Sin descripción disponible', 80) }}</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-warning fw-bold">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 animate__animated animate__fadeIn">
            <div class="card glass border-0 shadow-lg p-5 mx-auto" style="max-width: 600px;">
                <i class="bi bi-car-front display-1 text-warning mb-4"></i>
                <h3 class="text-white mb-3">No hay coches disponibles</h3>
                <p class="text-white-50 mb-4">Sé el primero en publicar un coche en el catálogo.</p>
                @auth
                    <a href="{{ route('cars.create') }}" class="btn btn-warning fw-bold px-5">
                        <i class="bi bi-plus-lg me-2"></i>Publicar el Primero
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-warning fw-bold px-5">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Acceder para Publicar
                    </a>
                @endauth
            </div>
        </div>
    @endif
</div>
@endsection

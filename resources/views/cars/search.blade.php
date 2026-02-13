@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <!-- Header with Filters in Container -->
    <div class="container mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-2 mb-4">
            <i class="bi bi-search me-2"></i>BÚSQUEDA AVANZADA
        </h1>
        
        <div class="card glass border-0 shadow-lg">
            <div class="card-body p-4">
                <form action="{{ route('cars.search') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-white-50 small text-uppercase">Modelo / Palabra clave</label>
                        <input type="text" name="search" class="form-control bg-dark text-white border-white border-opacity-25 py-2" placeholder="Ej: SF-24..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-white-50 small text-uppercase">Año</label>
                        <select name="year" class="form-select bg-dark text-white border-white border-opacity-25 py-2">
                            <option value="">Todos</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-white-50 small text-uppercase">Precio Máximo</label>
                        <select name="price" class="form-select bg-dark text-white border-white border-opacity-25 py-2">
                            <option value="">Cualquier precio</option>
                            <option value="5000000" {{ request('price') == '5000000' ? 'selected' : '' }}>Hasta 5M €</option>
                            <option value="10000000" {{ request('price') == '10000000' ? 'selected' : '' }}>Hasta 10M €</option>
                            <option value="15000000" {{ request('price') == '15000000' ? 'selected' : '' }}>Hasta 15M €</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning fw-bold w-100 py-2">
                            <i class="bi bi-filter me-2"></i>APLICAR FILTROS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($cars->count() > 0)
        <!-- Grid View for Search Results -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 fade-in-subtle">
            @foreach($cars as $car)
                <div class="col">
                    <div class="card glass border-0 h-100 shadow-sm hover-grow overflow-hidden">
                        <div class="position-relative" style="height: 200px;">
                            @if($car->image_url)
                                <img src="{{ $car->image_url }}" class="w-100 h-100 object-fit-cover" alt="{{ $car->model }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-dark">
                                    <i class="bi bi-car-front display-4 text-warning opacity-25"></i>
                                </div>
                            @endif
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1">{{ $car->year }}</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h5 class="fw-bold mb-0 text-truncate">{{ $car->model }}</h5>
                                <span class="text-warning fw-bold">{{ number_format($car->price / 1000000, 1) }}M€</span>
                            </div>
                            <p class="text-white-50 small mb-3">{{ $car->brand->name }} • {{ $car->team->name }}</p>
                            
                            <div class="row g-1 mb-3 text-center">
                                <div class="col-4 border-end border-white border-opacity-10">
                                    <small class="text-white-50 d-block" style="font-size: 0.6rem;">SPEED</small>
                                    <small class="fw-bold">{{ $car->top_speed ?? '---' }}</small>
                                </div>
                                <div class="col-4 border-end border-white border-opacity-10">
                                    <small class="text-white-50 d-block" style="font-size: 0.6rem;">0-100</small>
                                    <small class="fw-bold">{{ $car->acceleration ?? '---' }}s</small>
                                </div>
                                <div class="col-4">
                                    <small class="text-white-50 d-block" style="font-size: 0.6rem;">POWER</small>
                                    <small class="fw-bold">{{ $car->horsepower ?? '---' }}</small>
                                </div>
                            </div>

                            <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-warning btn-sm w-100 fw-bold">VER MÁS</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="container mt-5">
            {{ $cars->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-warning opacity-25 mb-4"></i>
            <h3 class="text-white">No se encontraron resultados</h3>
            <p class="text-white-50">Prueba con otros criterios de búsqueda.</p>
        </div>
    @endif
</div>

<style>
.hover-grow { transition: transform 0.3s ease; }
.hover-grow:hover { transform: scale(1.02); }
</style>
@endsection

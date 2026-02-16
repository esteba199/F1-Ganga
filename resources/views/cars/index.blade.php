@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4 fade-in-subtle">
    <div class="container mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-2 mb-2">
            <i class="bi bi-grid me-2"></i>CATÁLOGO F1
        </h1>
        <p class="text-white-50 lead">Explora nuestra selección exclusiva de monoplazas de leyenda.</p>
    </div>

    @if($cars->count() > 0)
        <div class="row g-4 animate__animated animate__fadeInUp">
            @foreach($cars as $car)
                <div class="col-12">
                    <div class="card glass border-0 shadow-lg overflow-hidden hover-lift">
                        <div class="row g-0">
                            <!-- Image Column -->
                            <div class="col-md-6 position-relative">
                                <div class="position-relative h-100" style="min-height: 400px;">
                                    @if($car->image_url)
                                        <img src="{{ $car->image_url }}" class="w-100 h-100 object-fit-cover shadow-lg" alt="{{ $car->model }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark">
                                            <i class="bi bi-car-front display-1 text-warning opacity-25"></i>
                                        </div>
                                    @endif
                                    <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-uppercase fw-bold py-2 px-3 shadow">{{ $car->year }}</span>
                                </div>
                            </div>

                            <!-- Details Column -->
                            <div class="col-md-6">
                                <div class="card-body p-4 d-flex flex-column h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h2 class="fw-bold text-warning mb-1 h3">{{ $car->model }}</h2>
                                            <p class="text-white-50 mb-0">
                                                <i class="bi bi-tag-fill text-warning me-1 small"></i>{{ $car->brand->name }} • 
                                                <i class="bi bi-flag-fill text-warning ms-2 me-1 small"></i>{{ $car->team->name }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h2 class="text-warning fw-bold mb-0">{{ number_format($car->price / 1000000, 1) }}M€</h2>
                                            <small class="text-white-50">{{ number_format($car->price, 0, ',', '.') }}€</small>
                                        </div>
                                    </div>

                                    <p class="text-white-50 mb-4 flex-grow-1 small">{{ Str::limit($car->description, 120) }}</p>

                                    <!-- Technical Specs (2x2 Grid) -->
                                    <div class="row g-2 mb-4">
                                        <div class="col-6">
                                            <div class="spec-box p-3 rounded glass bg-dark bg-opacity-25 border border-white border-opacity-10">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-speedometer text-warning fs-4"></i>
                                                    <div>
                                                        <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.75rem;">SPEED</small>
                                                        <span class="text-white fw-bold fs-5">{{ $car->top_speed ?? '---' }} <span class="fs-6 fw-normal text-white-50">km/h</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="spec-box p-3 rounded glass bg-dark bg-opacity-25 border border-white border-opacity-10">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-lightning-charge text-warning fs-4"></i>
                                                    <div>
                                                        <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.75rem;">0-100</small>
                                                        <span class="text-white fw-bold fs-5">{{ $car->acceleration ?? '---' }} <span class="fs-6 fw-normal text-white-50">s</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="spec-box p-3 rounded glass bg-dark bg-opacity-25 border border-white border-opacity-10">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-gear text-warning fs-4"></i>
                                                    <div>
                                                        <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.75rem;">ENGINE</small>
                                                        <span class="text-white fw-bold fs-5">{{ Str::limit($car->engine ?? '---', 10) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="spec-box p-3 rounded glass bg-dark bg-opacity-25 border border-white border-opacity-10">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-fire text-warning fs-4"></i>
                                                    <div>
                                                        <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.75rem;">POWER</small>
                                                        <span class="text-white fw-bold fs-5">{{ $car->horsepower ?? '---' }} <span class="fs-6 fw-normal text-white-50">HP</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-warning btn-lg flex-grow-1 fw-bold">
                                            <i class="bi bi-eye me-2"></i>VER DETALLES
                                        </a>
                                        @auth
                                            <button onclick="addToCart({{ $car->id }})" class="btn btn-warning btn-lg fw-bold flex-grow-1">
                                                <i class="bi bi-cart-plus me-2"></i>AÑADIR AL CARRITO
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5 mb-5">
            <div class="pagination-glass">
                {{ $cars->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-lift:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(253, 197, 0, 0.2) !important; }
.spec-box { transition: background 0.3s ease; }
.spec-box:hover { background: rgba(253, 197, 0, 0.1) !important; }
</style>
@endsection

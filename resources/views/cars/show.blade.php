@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('cars.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver al Catálogo
        </a>
        @auth
            @if(Auth::id() === $car->user_id || Auth::user()->is_admin)
                <div class="btn-group">
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    <form action="{{ route('cars.destroy', $car) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este coche?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="alert glass border-0 border-start border-4 border-success text-success mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Main Car Info -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card glass border-0 shadow-lg overflow-hidden">
                @if($car->image_url)
                    <img src="{{ $car->image_url }}" alt="{{ $car->model }}" class="w-100" style="max-height: 400px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-dark bg-opacity-50" style="height: 400px;">
                        <i class="bi bi-car-front display-1 text-warning opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card glass border-0 shadow-lg h-100">
                <div class="card-body p-5">
                    <h1 class="text-warning fw-bold mb-3">{{ $car->model }}</h1>
                    
                    <div class="mb-4">
                        <span class="badge bg-white bg-opacity-10 fs-6 py-2 px-3 me-2">
                            <i class="bi bi-tag-fill text-warning me-1"></i>{{ $car->brand->name }}
                        </span>
                        <span class="badge bg-white bg-opacity-10 fs-6 py-2 px-3">
                            <i class="bi bi-flag-fill text-warning me-1"></i>{{ $car->team->name }}
                        </span>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="text-white-50 small">Año</div>
                            <div class="fs-4 fw-bold text-warning">{{ $car->year }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-white-50 small">Precio</div>
                            <div class="fs-4 fw-bold text-warning">{{ number_format($car->price, 0, ',', '.') }}€</div>
                        </div>
                    </div>

                    @if($car->description)
                        <div class="mb-4">
                            <h6 class="text-warning mb-2">Descripción</h6>
                            <p class="text-white-50">{{ $car->description }}</p>
                        </div>
                    @endif

                    @auth
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning btn-lg fw-bold">
                                <i class="bi bi-cart-plus me-2"></i>Añadir al Carrito
                            </button>
                        </div>
                    @else
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-warning btn-lg fw-bold">
                                <i class="bi bi-lock me-2"></i>Inicia Sesión para Comprar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row">
        <div class="col-12">
            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 py-4">
                    <h4 class="mb-0 text-warning fw-bold">
                        <i class="bi bi-chat-dots me-2"></i>Reseñas ({{ $car->reviews->count() }})
                    </h4>
                </div>
                <div class="card-body p-5">
                    @if($car->reviews->count() > 0)
                        @foreach($car->reviews as $review)
                            <x-review-card :review="$review" />
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-chat display-1 text-warning opacity-25 mb-3"></i>
                            <p class="text-white-50">No hay reseñas todavía. ¡Sé el primero en opinar!</p>
                        </div>
                    @endif

                    @auth
                        <hr class="border-white border-opacity-10 my-4">
                        <h5 class="text-warning mb-3">Deja tu Reseña</h5>
                        <form action="{{ route('reviews.store', $car) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label text-warning fw-bold">Calificación</label>
                                <select name="rating" id="rating" class="form-select glass border-white border-opacity-25" style="background-color: rgba(0,0,0,0.3) !important; color: white;" required>
                                    <option value="" class="bg-dark">Selecciona...</option>
                                    <option value="5" class="bg-dark">★★★★★ Excelente</option>
                                    <option value="4" class="bg-dark">★★★★☆ Muy Bueno</option>
                                    <option value="3" class="bg-dark">★★★☆☆ Bueno</option>
                                    <option value="2" class="bg-dark">★★☆☆☆ Regular</option>
                                    <option value="1" class="bg-dark">★☆☆☆☆ Malo</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label text-warning fw-bold">Comentario</label>
                                <textarea name="comment" id="comment" class="form-control glass border-white border-opacity-25" rows="4" style="background-color: rgba(0,0,0,0.3) !important; color: white;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning fw-bold px-4">
                                <i class="bi bi-send me-2"></i>Publicar Reseña
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

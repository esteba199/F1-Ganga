@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-1">EDITAR <span class="text-white">COCHE</span></h1>
        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    @if($errors->any())
        <div class="alert glass border-0 border-start border-4 border-danger text-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card glass border-0 shadow-lg">
        <div class="card-body p-5">
            <form method="POST" action="{{ route('cars.update', $car) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="model" class="form-label text-warning fw-bold">Modelo</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $car->model) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="year" class="form-label text-warning fw-bold">Año</label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $car->year) }}" min="1950" max="{{ date('Y') + 1 }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="brand_id" class="form-label text-warning fw-bold">Marca</label>
                        <select class="form-select bg-dark text-white border-white border-opacity-25" id="brand_id" name="brand_id" required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $car->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="team_id" class="form-label text-warning fw-bold">Equipo</label>
                        <select class="form-select bg-dark text-white border-white border-opacity-25" id="team_id" name="team_id" required>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id', $car->team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="top_speed" class="form-label text-warning fw-bold">Velocidad Máxima (km/h)</label>
                        <input type="number" class="form-control" id="top_speed" name="top_speed" value="{{ old('top_speed', $car->top_speed) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="acceleration" class="form-label text-warning fw-bold">Aceleración 0-100 (s)</label>
                        <input type="number" class="form-control" id="acceleration" name="acceleration" value="{{ old('acceleration', $car->acceleration) }}" min="0" step="0.1">
                    </div>
                    <div class="col-md-4">
                        <label for="horsepower" class="form-label text-warning fw-bold">Potencia (CV)</label>
                        <input type="number" class="form-control" id="horsepower" name="horsepower" value="{{ old('horsepower', $car->horsepower) }}" min="0">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="engine" class="form-label text-warning fw-bold">Motor</label>
                        <input type="text" class="form-control" id="engine" name="engine" value="{{ old('engine', $car->engine) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="transmission" class="form-label text-warning fw-bold">Transmisión</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" value="{{ old('transmission', $car->transmission) }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label text-warning fw-bold">Precio (€)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $car->price) }}" min="0" step="0.01" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-warning fw-bold">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $car->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label text-warning fw-bold">Imagen del Coche (opcional)</label>
                    @if($car->image_url)
                        <div class="mb-2">
                            <img src="{{ $car->image_url }}" class="rounded shadow-sm" style="width: 150px; height: 100px; object-fit: cover;" alt="Current image">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text text-white-50 small">Deja vacío para mantener la imagen actual.</div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-5">
                    <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-5">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

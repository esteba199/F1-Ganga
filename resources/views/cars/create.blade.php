@extends('layouts.app')

@section('content')
<div class="container animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-warning letter-spacing-1">PUBLICAR <span class="text-white">COCHE</span></h1>
        <a href="{{ route('cars.index') }}" class="btn btn-outline-light rounded-pill px-4">
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
            <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="model" class="form-label text-warning fw-bold">Modelo</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="year" class="form-label text-warning fw-bold">Año</label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" min="1950" max="{{ date('Y') + 1 }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="brand_id" class="form-label text-warning fw-bold">Marca</label>
                        <select class="form-select bg-dark text-white border-white border-opacity-25" id="brand_id" name="brand_id" required>
                            <option value="">Selecciona una marca...</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="team_id" class="form-label text-warning fw-bold">Equipo</label>
                        <select class="form-select bg-dark text-white border-white border-opacity-25" id="team_id" name="team_id" required>
                            <option value="">Selecciona un equipo...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="top_speed" class="form-label text-warning fw-bold">Velocidad Máxima (km/h)</label>
                        <input type="number" class="form-control" id="top_speed" name="top_speed" value="{{ old('top_speed') }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="acceleration" class="form-label text-warning fw-bold">Aceleración 0-100 (s)</label>
                        <input type="number" class="form-control" id="acceleration" name="acceleration" value="{{ old('acceleration') }}" min="0" step="0.1">
                    </div>
                    <div class="col-md-4">
                        <label for="horsepower" class="form-label text-warning fw-bold">Potencia (CV)</label>
                        <input type="number" class="form-control" id="horsepower" name="horsepower" value="{{ old('horsepower') }}" min="0">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="engine" class="form-label text-warning fw-bold">Motor</label>
                        <input type="text" class="form-control" id="engine" name="engine" value="{{ old('engine') }}" placeholder="Ej: V6 Turbo Hybrid 1.6L">
                    </div>
                    <div class="col-md-6">
                        <label for="transmission" class="form-label text-warning fw-bold">Transmisión</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" value="{{ old('transmission') }}" placeholder="Ej: 8-speed semi-automatic">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label text-warning fw-bold">Precio (€)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-warning fw-bold">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label text-warning fw-bold">Imagen del Coche</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text text-white-50 small">Formatos aceptados: JPG, PNG, GIF, WEBP. Máximo 5MB.</div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-5">
                    <a href="{{ route('cars.index') }}" class="btn btn-outline-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-5">
                        <i class="bi bi-check-lg me-2"></i>Publicar Coche
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

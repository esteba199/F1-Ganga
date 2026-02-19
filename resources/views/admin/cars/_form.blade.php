<style>
    select.form-select, select.form-select option {
        color: #000 !important;
        background-color: #fff !important;
    }
    select.form-select option:checked {
        background: linear-gradient(#0d6efd, #0d6efd) !important;
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>

<div class="mb-3">
    <label class="form-label fw-bold text-white">Modelo <span class="text-danger">*</span></label>
    <input type="text" name="model" value="{{ old('model', $car->model ?? '') }}" class="form-control @error('model') is-invalid @enderror" required>
    @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold text-white">Marca <span class="text-danger">*</span></label>
        <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
            <option value="">-- Seleccionar marca --</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ (old('brand_id', $car->brand_id ?? '') == $b->id) ? 'selected' : '' }}>{{ $b->name }}</option>
            @endforeach
        </select>
        @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold text-white">Equipo <span class="text-danger">*</span></label>
        <select name="team_id" class="form-select @error('team_id') is-invalid @enderror" required>
            <option value="">-- Seleccionar equipo --</option>
            @foreach($teams as $t)
                <option value="{{ $t->id }}" {{ (old('team_id', $car->team_id ?? '') == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
            @endforeach
        </select>
        @error('team_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Año <span class="text-danger">*</span></label>
        <input type="number" name="year" value="{{ old('year', $car->year ?? '') }}" class="form-control @error('year') is-invalid @enderror" required>
        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Precio <span class="text-danger">*</span></label>
        <input type="text" name="price" value="{{ old('price', $car->price ?? '') }}" class="form-control @error('price') is-invalid @enderror" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Caballos (hp)</label>
        <input type="number" name="horsepower" value="{{ old('horsepower', $car->horsepower ?? '') }}" class="form-control @error('horsepower') is-invalid @enderror">
        @error('horsepower') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold text-white">Velocidad Máx (km/h)</label>
        <input type="number" name="top_speed" value="{{ old('top_speed', $car->top_speed ?? '') }}" class="form-control @error('top_speed') is-invalid @enderror">
        @error('top_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold text-white">Aceleración (0-100s)</label>
        <input type="number" name="acceleration" step="0.1" value="{{ old('acceleration', $car->acceleration ?? '') }}" class="form-control @error('acceleration') is-invalid @enderror">
        @error('acceleration') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold text-white">Motor</label>
        <input type="text" name="engine" value="{{ old('engine', $car->engine ?? '') }}" class="form-control @error('engine') is-invalid @enderror">
        @error('engine') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-bold text-white">Transmisión</label>
        <input type="text" name="transmission" value="{{ old('transmission', $car->transmission ?? '') }}" class="form-control @error('transmission') is-invalid @enderror">
        @error('transmission') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-white">Descripción</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $car->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-white">Imagen</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if(!empty($car->image_url))
        <div class="mt-2"><img src="{{ asset($car->image_url) }}" style="max-height:100px" class="rounded"></div>
    @endif
</div>

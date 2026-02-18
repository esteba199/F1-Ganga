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
    <input type="text" name="model" value="{{ old('model', $car->model ?? '') }}" class="form-control" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold text-white">Marca <span class="text-danger">*</span></label>
        <select name="brand_id" class="form-select" required>
            <option value="">-- Seleccionar marca --</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ (old('brand_id', $car->brand_id ?? '') == $b->id) ? 'selected' : '' }}>{{ $b->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold text-white">Equipo <span class="text-danger">*</span></label>
        <select name="team_id" class="form-select" required>
            <option value="">-- Seleccionar equipo --</option>
            @foreach($teams as $t)
                <option value="{{ $t->id }}" {{ (old('team_id', $car->team_id ?? '') == $t->id) ? 'selected' : '' }}>{{ $t->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Año <span class="text-danger">*</span></label>
        <input type="number" name="year" value="{{ old('year', $car->year ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Precio <span class="text-danger">*</span></label>
        <input type="text" name="price" value="{{ old('price', $car->price ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-white">Caballos (hp)</label>
        <input type="number" name="horsepower" value="{{ old('horsepower', $car->horsepower ?? '') }}" class="form-control">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-white">Descripción</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $car->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-white">Imagen</label>
    <input type="file" name="image" class="form-control">
    @if(!empty($car->image_url))
        <div class="mt-2"><img src="{{ asset($car->image_url) }}" style="max-height:100px" class="rounded"></div>
    @endif
</div>

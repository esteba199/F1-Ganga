{{-- Campo: Nombre del equipo (obligatorio) --}}
<div class="mb-3">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $team->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Campo: Principal/Director del equipo (opcional) --}}
<div class="mb-3">
    <label class="form-label">Principal / Director</label>
    <input type="text" name="principal" value="{{ old('principal', $team->principal ?? '') }}" class="form-control @error('principal') is-invalid @enderror" placeholder="E.g: Christian Horner...">
    @error('principal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

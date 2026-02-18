{{-- Campo: Nombre de la marca (obligatorio) --}}
<div class="mb-3">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" value="{{ old('name', $brand->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Campo: País de origen (opcional) --}}
<div class="mb-3">
    <label class="form-label">Country</label>
    <input type="text" name="country" value="{{ old('country', $brand->country ?? '') }}" class="form-control @error('country') is-invalid @enderror" placeholder="E.g: Italy, Germany...">
    @error('country')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

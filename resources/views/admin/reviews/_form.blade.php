{{-- Reusable form fields for reviews --}}

<div class="mb-3">
    <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
        <option value="">-- Select user --</option>
        @foreach($users as $id => $name)
            <option value="{{ $id }}" {{ (isset($review) && $review->user_id == $id) || old('user_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="car_id" class="form-label">Car <span class="text-danger">*</span></label>
    <select name="car_id" id="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
        <option value="">-- Select car --</option>
        @foreach($cars as $id => $model)
            <option value="{{ $id }}" {{ (isset($review) && $review->car_id == $id) || old('car_id') == $id ? 'selected' : '' }}>
                {{ $model }}
            </option>
        @endforeach
    </select>
    @error('car_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
    <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
        <option value="">-- Select rating --</option>
        @for($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" {{ (isset($review) && $review->rating == $i) || old('rating') == $i ? 'selected' : '' }}>
                {{ $i }} ⭐
            </option>
        @endfor
    </select>
    @error('rating')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="comment" class="form-label">Comment <span class="text-danger">*</span></label>
    <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5" required>{{ isset($review) ? $review->comment : old('comment') }}</textarea>
    <small class="form-text text-muted">Maximum 1000 characters.</small>
    @error('comment')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Car') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="model" class="form-label">{{ __('Model') }}</label>
                            <input type="text" class="form-control" id="model" name="model" required>
                        </div>

                        <div class="mb-3">
                            <label for="team" class="form-label">{{ __('Team') }}</label>
                            <input type="text" class="form-control" id="team" name="team" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('Save Car') }}</button>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

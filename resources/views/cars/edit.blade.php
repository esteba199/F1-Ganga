@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Car') }}</div>

                <div class="card-body">
                    <p>Edit Car Data Form</p>
                    <a href="{{ route('cars.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

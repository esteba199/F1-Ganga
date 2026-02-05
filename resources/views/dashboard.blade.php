@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">
                    {{ __('Dashboard') }}
                </div>

                <div class="card-body">
                    <p class="mb-0 text-success">
                        {{ __("You're logged in!") }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

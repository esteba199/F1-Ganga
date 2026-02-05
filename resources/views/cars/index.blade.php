@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Cars') }}</span>
                    <a href="{{ route('cars.create') }}" class="btn btn-primary btn-sm">{{ __('Add Car') }}</a>
                </div>

                <div class="card-body">
                    <p>{{ __("List of Cars") }}</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Model</th>
                                <th>Team</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

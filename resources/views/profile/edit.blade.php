@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 gap-4 d-flex flex-column">
            
            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 text-warning fw-bold">{{ __('Update Profile Information') }}</div>
                <div class="card-body p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="card glass border-0 shadow-lg">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 text-warning fw-bold">{{ __('Update Password') }}</div>
                <div class="card-body p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="card glass border-0 shadow-lg border-start border-4 border-danger">
                <div class="card-header bg-transparent border-bottom border-white border-opacity-10 text-danger fw-bold">{{ __('Delete Account') }}</div>
                <div class="card-body p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

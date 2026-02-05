@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 gap-4 d-flex flex-column">
            
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">{{ __('Update Profile Information') }}</div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">{{ __('Update Password') }}</div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-danger">
                <div class="card-header bg-white text-danger font-weight-bold">{{ __('Delete Account') }}</div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

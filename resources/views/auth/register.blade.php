<x-guest-layout>
    <h4 class="text-white mb-4 fw-bold text-center">Crear Cuenta</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Nombre')" class="text-white-50" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="text-danger small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white-50" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white-50" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white-50" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small" />
        </div>

        <div class="d-grid gap-2 mt-4">
            <x-primary-button class="btn-warning text-dark fw-bold">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <p class="text-white-50 small mb-0">¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold">
                    Inicia sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

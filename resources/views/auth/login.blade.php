<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h4 class="text-white mb-4 fw-bold text-center">Iniciar Sesión</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-white-50" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white-50" />

            <x-text-input id="password"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="text-danger small" />
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-white-50">{{ __('Recordarme') }}</label>
        </div>

        <div class="d-grid gap-2 mt-4">
            <x-primary-button class="btn-warning text-dark fw-bold">
                {{ __('Acceder') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <p class="text-white-50 small mb-2">¿Eres nuevo por aquí?</p>
            <a class="text-warning text-decoration-none fw-bold" href="{{ route('register') }}">
                Crear una cuenta →
            </a>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="text-white-50 small text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>

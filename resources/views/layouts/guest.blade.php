<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="bg-dark text-light overflow-hidden" style="background: radial-gradient(circle at top right, #1a1e23 0%, #0b0e11 100%);">
        <div class="container d-flex flex-column min-vh-100 justify-content-center py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="text-center mb-5 animate__animated animate__fadeInDown">
                        <a href="/" class="text-decoration-none">
                            <h1 class="fw-bold text-warning display-4 mb-0"><i class="bi bi-speedometer2 me-2"></i>F1 Ganga</h1>
                            <p class="text-white-50 letter-spacing-2 mt-2 font-monospace">PREMIUM ACCESS</p>
                        </a>
                    </div>

                    <div class="card glass border-0 bg-transparent shadow-lg py-3 animate__animated animate__fadeInUp">
                        <div class="card-body px-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>F1 Ganga</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">F1 Ganga</a>
                <div class="ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            @section('content')
<div class="hero-section text-center py-5 mb-5 position-relative overflow-hidden" style="margin-top: -3rem;">
    <!-- Background video/image placeholder simulation with gradient -->
    <div class="position-absolute w-100 h-100 top-0 start-0 z-0 bg-dark opacity-75"></div>
    
    <div class="container position-relative z-1 py-5 animate__animated animate__fadeIn">
        <h1 class="display-1 fw-bold text-white mb-2 letter-spacing-3">VELOCIDAD <span class="text-warning">PURA</span></h1>
        <p class="lead text-white-50 mb-5 fs-4 font-monospace">EL MERCADO EXCLUSIVO PARA AMANTES DE LA F1</p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('cars.index') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg animate__animated animate__pulse animate__infinite">
                EXPLORAR CATÁLOGO
            </a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold rounded-pill">
                    UNIRSE A LA ÉLITE
                </a>
            @endguest
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <div class="card glass border-0 p-5 shadow-lg animate__animated animate__fadeInLeft">
                <h2 class="fw-bold text-warning mb-4">¿Por qué F1 Ganga?</h2>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-shield-check text-warning fs-3 me-3"></i> <div><strong>Garantía Élite:</strong> Todos los vehículos son verificados por expertos.</div></li>
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-lightning text-warning fs-3 me-3"></i> <div><strong>Trato Directo:</strong> Sin intermediarios, de coleccionista a coleccionista.</div></li>
                    <li class="mb-3 d-flex align-items-center"><i class="bi bi-globe text-warning fs-3 me-3"></i> <div><strong>Envío Global:</strong> Entregamos tu monoplaza en cualquier circuito.</div></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 text-center animate__animated animate__fadeInRight">
            <img src="https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&q=80&w=1200" alt="F1 Car" class="img-fluid rounded-4 shadow-lg border border-warning border-opacity-25">
        </div>
    </div>
</div>
@endsection
        </div>
    </body>
</html>

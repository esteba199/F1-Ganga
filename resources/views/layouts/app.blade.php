<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-dark text-light">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-glass sticky-top shadow-sm px-3">
            <div class="container">
                <a class="navbar-brand fw-bold text-warning fs-4" href="{{ url('/') }}">
                    <i class="bi bi-lightning-charge-fill me-2"></i>F1 GANGA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menú">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cars.index') ? 'active text-warning' : '' }}" href="{{ route('cars.index') }}">Catálogo</a>
                        </li>
                        @auth
                            @if(Auth::user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active text-warning' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-check me-1"></i>Admin
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-warning rounded-pill px-3" href="{{ route('login') }}">Acceder</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-warning text-dark btn-sm ms-lg-2 px-3 fw-bold" href="{{ route('register') }}">{{ __('Únete') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Mi Panel
                                    </a>
                                    
                                    @if(Auth::user()->is_admin)
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-shield-check me-2 text-warning"></i>Panel Admin
                                        </a>
                                    @endif
                                    
                                    <hr class="dropdown-divider opacity-10">
                                    
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5 min-vh-100">
            @yield('content')
        </main>

        <footer class="glass border-0 text-white pt-5 pb-4 mt-5 mx-3 mb-3">
            <div class="container text-center text-md-start">
                <div class="row">
                    <div class="col-md-3 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">F1 Ganga</h5>
                        <p class="text-white-50 small">Tu destino para los monoplazas más exclusivos. El lujo y la ingeniería al alcance de un click.</p>
                    </div>

                    <div class="col-md-2 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Secciones</h5>
                        <p><a href="{{ route('cars.index') }}" class="text-white-50 text-decoration-none hover-warning">Catálogo</a></p>
                        <p><a href="#" class="text-white-50 text-decoration-none hover-warning">Subastas</a></p>
                    </div>

                    <div class="col-md-3 mx-auto mt-3">
                        <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contacto</h5>
                        <p class="text-white-50 small"><i class="bi bi-geo-alt me-2"></i>Barcelona, ES</p>
                        <p class="text-white-50 small"><i class="bi bi-envelope me-2"></i>vip@f1ganga.com</p>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="row align-items-center">
                    <div class="col-md-7">
                        <p class="text-white-50 small mb-0"> © {{ date('Y') }} <strong>F1 Ganga S.A.</strong> - Ingeniería de Élite.</p>
                    </div>
                    <div class="col-md-5 text-end">
                        <a href="#" class="text-white ms-3 fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white ms-3 fs-5"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

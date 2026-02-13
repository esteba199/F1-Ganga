<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'F1 Ganga') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' fill='%23ffc107' viewBox='0 0 16 16'><path d='M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5z'/></svg>">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-dark text-light">
    <div id="app">
        <!-- Redesigned Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-glass sticky-top shadow-sm">
            <div class="container-fluid px-4">
                <!-- Logo (Left) -->
                <a class="navbar-brand fw-bold text-warning fs-4 me-5" href="{{ route('cars.index') }}">
                    <i class="bi bi-lightning-charge-fill me-2"></i>F1 GANGA
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    @auth
                        <!-- Center: Main Navigation Items (equal spacing) -->
                        <ul class="navbar-nav mx-auto d-flex gap-4">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cars.index') ? 'active text-warning' : 'text-white' }}" href="{{ route('cars.index') }}">
                                    <i class="bi bi-grid me-1"></i>Catálogo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cars.search') ? 'active text-warning' : 'text-white' }}" href="{{ route('cars.search') }}">
                                    <i class="bi bi-search me-1"></i>Búsqueda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-warning' : 'text-white' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Panel
                                </a>
                            </li>
                            <li class="nav-item position-relative">
                                <a class="nav-link {{ request()->routeIs('cart.index') ? 'active text-warning' : 'text-white' }}" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart3 me-1"></i>Carrito
                                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                                    @if($cartCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem; padding:0.2em 0.4em;">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>

                        <!-- Right: Account Dropdown -->
                        <ul class="navbar-nav ms-auto">
                            @if(auth()->user()->is_admin)
                                <li class="nav-item me-3">
                                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active text-warning' : 'text-white' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-check me-1"></i>Admin
                                    </a>
                                </li>
                            @endif
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag-check me-2"></i>Mis Pedidos
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        </ul>
                    @else
                        <!-- Guest: Login/Register -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-warning rounded-pill px-3" href="{{ route('login') }}">Acceder</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-warning text-dark btn-sm ms-2 px-3 fw-bold" href="{{ route('register') }}">Únete</a>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>

        <!-- Minimalist Footer -->
        <footer class="mt-5 py-4 glass border-top border-white border-opacity-10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0 text-center text-md-start">
                        <h5 class="text-warning fw-bold mb-0">
                            <i class="bi bi-lightning-charge-fill me-2"></i>F1 GANGA
                        </h5>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0 text-center">
                        <div class="d-flex justify-content-center gap-4">
                            <a href="{{ route('cars.index') }}" class="text-white-50 text-decoration-none small hover-warning">Catálogo</a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-white-50 text-decoration-none small hover-warning">Panel</a>
                                <a href="{{ route('orders.index') }}" class="text-white-50 text-decoration-none small hover-warning">Pedidos</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-4 text-center text-md-end">
                        <p class="text-white-50 small mb-0">&copy; {{ date('Y') }} F1 GANGA</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

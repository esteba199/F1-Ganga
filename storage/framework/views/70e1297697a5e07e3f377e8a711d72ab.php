<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'F1 Ganga')); ?></title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
</head>
<body class="bg-dark text-light">
    <div id="app">
        <!-- Redesigned Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-glass sticky-top shadow-sm">
            <div class="container-fluid px-4">
                <!-- Logo (Left) -->
                <a class="navbar-brand fw-bold text-warning fs-4 me-5" href="<?php echo e(route('cars.index')); ?>">
                    <i class="bi bi-lightning-charge-fill me-2"></i>F1 GANGA
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <?php if(auth()->guard()->check()): ?>
                        <!-- Center: Main Navigation Items (equal spacing) -->
                        <ul class="navbar-nav mx-auto d-flex gap-4">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('cars.index') ? 'active text-warning' : 'text-white'); ?>" href="<?php echo e(route('cars.index')); ?>">
                                    <i class="bi bi-grid me-1"></i>Catálogo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('cars.search') ? 'active text-warning' : 'text-white'); ?>" href="<?php echo e(route('cars.search')); ?>">
                                    <i class="bi bi-search me-1"></i>Búsqueda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active text-warning' : 'text-white'); ?>" href="<?php echo e(route('dashboard')); ?>">
                                    <i class="bi bi-speedometer2 me-1"></i>Panel
                                </a>
                            </li>
                            <li class="nav-item position-relative">
                                <a class="nav-link <?php echo e(request()->routeIs('cart.index') ? 'active text-warning' : 'text-white'); ?>" href="<?php echo e(route('cart.index')); ?>">
                                    <i class="bi bi-cart3 me-1"></i>Carrito
                                    <?php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); ?>
                                    <?php if($cartCount > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem; padding:0.2em 0.4em;"><?php echo e($cartCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>

                        <!-- Right: Account Dropdown -->
                        <ul class="navbar-nav ms-auto">
                            <?php if(auth()->user()->is_admin): ?>
                                <li class="nav-item me-3">
                                    <a class="nav-link <?php echo e(request()->routeIs('admin.*') ? 'active text-warning' : 'text-white'); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="bi bi-shield-check me-1"></i>Admin
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i><?php echo e(auth()->user()->name); ?>

                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                    <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                        <i class="bi bi-bag-check me-2"></i>Mis Pedidos
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
                                </div>
                            </li>
                        </ul>
                    <?php else: ?>
                        <!-- Guest: Login/Register -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-warning rounded-pill px-3" href="<?php echo e(route('login')); ?>">Acceder</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-warning text-dark btn-sm ms-2 px-3 fw-bold" href="<?php echo e(route('register')); ?>">Únete</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
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
                            <a href="<?php echo e(route('cars.index')); ?>" class="text-white-50 text-decoration-none small hover-warning">Catálogo</a>
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('dashboard')); ?>" class="text-white-50 text-decoration-none small hover-warning">Panel</a>
                                <a href="<?php echo e(route('orders.index')); ?>" class="text-white-50 text-decoration-none small hover-warning">Pedidos</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4 text-center text-md-end">
                        <p class="text-white-50 small mb-0">&copy; <?php echo e(date('Y')); ?> F1 GANGA</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
<?php /**PATH D:\F1-Ganga\resources\views/layouts/app.blade.php ENDPATH**/ ?>
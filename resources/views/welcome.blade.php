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
            <div class="jumbotron text-center bg-light p-5 rounded">
                <h1 class="display-4">Welcome to F1 Ganga</h1>
                <p class="lead">The best place to find your F1 car.</p>
                <hr class="my-4">
                <p>Start exploring our catalog.</p>
                <a class="btn btn-primary btn-lg" href="{{ route('cars.index') }}" role="button">View Cars</a>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <header class="container-fluid">
            <!-- Large screen header -->
            <div class="d-none d-lg-block sticky-top">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <a href="#"><img src="logo.png" alt="Logo" class="img-fluid"></a>
                    </div>
                    <div class="col-lg-7">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for products">
                            <button class="btn btn-outline-secondary" type="button">Search</button>
                        </div>
                    </div>
                    <div class="col-lg-3 text-end">
                        <a href="#" class="me-3">Register</a>
                        <a href="#" class="me-3">Login</a>
                        <a href="#" class="position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">3</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <nav>
                            <ul class="nav">
                                <li class="nav-item"><a href="#" class="nav-link">Link 1</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 2</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 3</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 4</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Medium and Small screen header -->
            <div class="d-lg-none sticky-top">
                <div class="row align-items-center">
                    <div class="col-2">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-6">
                        <a href="#"><img src="logo.png" alt="Logo" class="img-fluid"></a>
                    </div>
                    <div class="col-4 text-end">
                        <a href="#" class="me-3">Register</a>
                        <a href="#" class="me-3">Login</a>
                        <a href="#" class="position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">3</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a href="#" class="nav-link">Link 1</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 2</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 3</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Link 4</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-lg-none mt-2">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for products">
                            <button class="btn btn-outline-secondary" type="button">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>

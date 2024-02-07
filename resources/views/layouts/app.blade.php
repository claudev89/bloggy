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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body data-bs-theme="dark">
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <button onclick="cambiarTema()" class="btn rounded-fill"><i id="dl-icon" class="bi bi-sun-fill"></i> </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                       @foreach($categories as $category)
                           @if($category->subcategory->isNotEmpty())
                                <li class="nav-item dropdown" onclick="window.location.href='{{ route('categories.show', $category) }}'">
                                    <a class="nav-link dropdown-toggle" href="{{ route('categories.show', $category) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $category->name }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($category->subcategory as $subcategory)
                                            <li><a class="dropdown-item" href="{{ route('categories.show', $subcategory) }}">{{ $subcategory->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                       @endforeach

                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script>
    const temaOscuro = () => {
        document.querySelector("body").setAttribute("data-bs-theme", "dark");
        document.querySelector("#dl-icon").setAttribute("class", "bi bi-sun-fill");
    }

    const temaClaro = () => {
        document.querySelector("body").setAttribute("data-bs-theme", "light");
        document.querySelector("#dl-icon").setAttribute("class", "bi bi-moon-fill");
    }

    const cambiarTema = () => {
        document.querySelector("body").getAttribute("data-bs-theme") === "dark"? temaClaro() : temaOscuro();
    }
</script>

<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }
</style>
</html>

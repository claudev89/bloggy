@php($postsOrderByDate = \App\Models\Post::where('borrador', 0)->orderBy('created_at', 'desc')->take(3)->get())
@php($postsOrderByPopularity = \App\Models\Post::where('borrador', 0)->orderBy('views', 'desc')->take(3)->get())
@php($postsOrderRandomOrder = \App\Models\Post::where('borrador', 0)->inRandomOrder()->take(3)->get())

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
            <button onclick="cambiarTema()" class="btn rounded-fill"><i id="dl-icon" class="bi bi-sun-fill"></i>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/images/bg.png" alt="app.name" width="24" height="24"> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="autoXpand">
                    @php($categories = \App\Models\Category::whereNull('parentCategory')->get())
                    @foreach($categories as $category)
                        @if($category->subcategory->isNotEmpty())
                            <li class="nav-item dropdown"
                                onclick="window.location.href='{{ route('categories.show', $category) }}'">
                                <a class="nav-link dropdown-toggle" href="{{ route('categories.show', $category) }}"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($category->subcategory as $subcategory)
                                        <li><a class="dropdown-item"
                                               href="{{ route('categories.show', $subcategory) }}">{{ $subcategory->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                    <a class="nav-link" href="{{ route('contacto.index') }}">Contacto</a>

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

                        @auth
                            @php($user = \App\Models\User::find(auth()->id()))
                            @php($notifications = $user->allNotifications()->get())


                            <li class="nav-item dropdown mt-1" id="notificaciones">
                                <button class="btn btn-dark- dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell-fill"></i>
                                    @if($notifications->count()>0)
                                        @if($notifications->where('read', 0)->count()>0)
                                            <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger">
                                                    {{ $notifications->where('read', 0)->count() }}
                                                </span>
                                        @endif
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" style="width: 22rem;">

                            @forelse($notifications as $notification)
                                @php( $user = \App\Models\User::find($notification->user_id))
                                @if( $notification->notifiable_type == 'c')
                                    @php( $comment = \App\Models\Comentario::find($notification->notifiable_id))
                                @endif

                                @if( $notification->type == 'l')
                                    @php( $action = "<i class='bi bi-chat-square-heart'></i>  le ha dado like a tu " )
                                @elseif( $notification->type == 'c')
                                    @php( $action = "<i class='bi bi-chat-square'></i> ha comentado tu " )
                                @endif

                                @if( $notification->notifiable_type == 'p')
                                            @php( $postN = \App\Models\Post::find($notification->notifiable_id ))
                                    @php( $element = "<a href='".route('posts.show', $postN)."' class='text-reset' style='text-decoration: none'>publicación </a>")
                                @elseif( $notification->notifiable_type == 'c')
                                    @php( $postN = \App\Models\Post::find(\App\Models\Comentario::find($notification->notifiable_id)->id))
                                    @if(!is_null($comment->respuestaA))
                                        @php( $autor = \App\Models\User::find(\App\Models\Comentario::find($notification->notifiable_id)->autor ))
                                        @php( $element = "respuesta al comentario de <a href='".route('users.show', $autor)."' class='text-reset' style='text-decoration: none'>".$autor->name."</a> en la <a href='".route('posts.show', $postN)."' class='text-reset' style='text-decoration: none'>publicación </a> de <a href='".route('users.show', $comment->post->user)."' class='text-reset' style='text-decoration: none'>".$comment->post->user->name."</a>")
                                            @else
                                                @php( $element = "comentario en la <a href='".route('posts.show', $postN)."' class='text-reset' style='text-decoration: none'> publicación</a> de <a href='".route('users.show', \App\Models\User::find($postN->autor))."' class='text-reset' style='text-decoration: none'>".\App\Models\User::find($postN->autor)->name."</a>" )
                                        @endif
                                @endif
                                        <li><a class="dropdown-item p-0" href="#">
                                                <div class="card p-0 ist-group-item list-group-item-action {{ $notification->read === 0 ? 'bg-secondary border-dark' :''}}">
                                                    <div class="card-body p-1">
                                                        <a href="#">
                                                            <div class="row" onclick="window.location.href = '{{ route('notifications.show', ['notification' => $notification->id, 'postId' => $postN->id]) }}';" style="cursor: pointer;">
                                                            <div class="col-3 pe-0"><a href="{{ route('users.show', $user) }}"><img class="w-100 rounded-circle" src="{{ $user->profile_photo_url }}"></a></div>
                                                                <div class="col text-reset ps-2">
                                                                    <strong><a href="{{ route('users.show', $user) }}" class="text-reset" style="text-decoration: none">{{ $user->name }} </a></strong><br>
                                                                    {!! $action !!} {!! $element !!}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a></li>
                            @empty
                                <p class="alert alert-dark">No tienes notificaciones.<p/>
                            @endforelse

                                <div class="mt-2 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-outline-light btn-sm">
                                        Ver todas las notificaciones
                                    </button>
                                </div>
                                </ul>
                            </li>

                        @endauth


                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

    <div class="container mt-3">
        <div class="row">

            <!-- Contenido principal de la página -->
            <div class="col-md-9">
                <div class="card p-3">
                @yield('content')
                </div>
            </div>

            <!-- Barra lateral derecha -->
            <div class="col-md-3 pt-3 card">
                <nav>
                    <div class="nav nav-tabs" id="3postsBLD" role="tablist">
                        <button class="nav-link active" id="nav-recents-tab" data-bs-toggle="tab" data-bs-target="#nav-recents" type="button" role="tab" aria-controls="nav-recents" aria-selected="true" style="color: inherit">Recientes</button>
                        <button class="nav-link" id="nav-populars-tab" data-bs-toggle="tab" data-bs-target="#nav-populars" type="button" role="tab" aria-controls="nav-populars" aria-selected="false" style="color: inherit">Populares</button>
                        <button class="nav-link" id="nav-random-tab" data-bs-toggle="tab" data-bs-target="#nav-random" type="button" role="tab" aria-controls="nav-random" aria-selected="false" style="color: inherit">Random</button>
                    </div>
                </nav>
                <div class="tab-content mt-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-recents" role="tabpanel" aria-labelledby="nav-recents-tab" tabindex="0">
                        @foreach($postsOrderByDate as $post)
                            <div class="card mb-2" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4 mt-4">
                                        <a href="{{ route('posts.show', $post) }}"><img src="{{ $post->image }}" class="img-fluid rounded-start" alt="{{ $post->description }}"></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a style="color: inherit; text-decoration: none" href="{{ route('posts.show', $post) }}"><h6 class="card-title">{{ $post->titulo }}</h6></a>
                                            <p class="card-text"><small class="text-body-secondary">{{ date('d/m/Y', strtotime($post->created_at)) }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="nav-populars" role="tabpanel" aria-labelledby="nav-populars-tab" tabindex="0">
                        @foreach($postsOrderByPopularity as $post)
                            <div class="card mb-2" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4 mt-4">
                                        <a href="{{ route('posts.show', $post) }}"><img src="{{ $post->image }}" class="img-fluid rounded-start" alt="{{ $post->description }}"></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a style="color: inherit; text-decoration: none" href="{{ route('posts.show', $post) }}"><h6 class="card-title">{{ $post->titulo }}</h6></a>
                                            <p class="card-text"><small class="text-body-secondary">{{ date('d/m/Y', strtotime($post->created_at)) }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="nav-random" role="tabpanel" aria-labelledby="nav-random-tab" tabindex="0">
                        @foreach($postsOrderRandomOrder as $post)
                            <div class="card mb-2" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4 mt-4">
                                        <a href="{{ route('posts.show', $post) }}"><img src="{{ $post->image }}" class="img-fluid rounded-start" alt="{{ $post->description }}"></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a style="color: inherit; text-decoration: none" href="{{ route('posts.show', $post) }}"><h6 class="card-title">{{ $post->titulo }}</h6></a>
                                            <p class="card-text"><small class="text-body-secondary">{{ date('d/m/Y', strtotime($post->created_at)) }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>
                <ul>
                    <li ><a style="color: inherit" class="text-decoration-none" href="/">Inicio</a></li>
                    @foreach($categories as $category)
                        @if($category->subcategory->isNotEmpty())
                            <li ><a style="color: inherit" class="text-decoration-none" href="{{ route('categories.show', $category) }}">{{ $category->name }}</li>
                            @foreach($category->subcategory as $subcategory) @endforeach
                            <ul>
                                <li ><a style="color: inherit" class="text-decoration-none" href="{{ route('categories.show', $subcategory) }}">{{ $subcategory->name }}</li>
                            </ul>
                        @else
                            <li ><a style="color: inherit" class="text-decoration-none" href="{{ route('categories.show', $category) }}">{{ $category->name }}</li>
                        @endif
                    @endforeach
                    <li ><a style="color: inherit" class="text-decoration-none" href="{{ route('contacto.index') }}">Contacto</a></li>
                </ul>
            </div>
                <!-- Fin de la barra latetal derecha -->
            </div>
        </div>

        <div class="container mb-3">
            <hr>
            <div class="row align-content-center">
                <div class="btn-group" role="group" aria-label="Footer Menu" id="footerMenu">
                    <button onclick="location.href = '/'" class="btn btn-outline-light">Inicio</button>
                    @foreach($categories as $category)
                        <button onclick="location.href = '{{ route('categories.show', $category) }}'" type="button" class="btn btn-outline-light">{{ $category->name }}</button>
                    @endforeach
                    <button onclick="location.href = '{{ route('contacto.index') }}'" type="button" class="btn btn-outline-light">Contacto</button>
                </div>
        </div>
        </div>
    </div>
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
        document.querySelector("body").getAttribute("data-bs-theme") === "dark" ? temaClaro() : temaOscuro();
    }
</script>

<style>
    #autoXpand .dropdown:hover > .dropdown-menu {
        display: block;
    }

    #autoXpand .dropdown > .dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }

    @media screen and (max-width: 768px) {
        #footerMenu{
            display: inline-grid;}
        }

    #notificaciones .dropdown-toggle::after {
        display: none; /* Oculta la flecha del dropdown */
    }

</style>
</html>

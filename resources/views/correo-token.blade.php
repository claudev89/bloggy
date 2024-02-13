<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body data-bs-theme="dark">
<a class="navbar-brand ms-2" href="{{ url('/') }}">
    <img src="/images/bg.png" alt="{{ config('app.name') }}" width="24" height="24"> {{ config('app.name', 'Laravel') }}
</a>

<div id="correo">
    <p></p>
    <p class="ms-2 me-2">Saludos, se ha enviado una solicitud para suscribirte a nuestra página web. Si la aceptas, periódicamente te enviaremos correos con todas las novedades en nuestro sitio, para que no te pierdas ninguna publicación.</p>
<div class="row justify-content-center">
    <div class="card text-center col-11 col-md-5 mt-4 mb-4">
        <div class="card-header">
            Suscripción a Newsletter
        </div>
        <div class="card-body">
            <h5 class="card-title">Solicitud de suscripción al newsletter de {{ config('app.name') }}</h5>
            <p class="card-text">Hemos recibido una solicitud para suscribirte a nuestro newsletter. Si no quieres perderte nuestro contenido, haz click en el botón "Confirmar suscripción", de lo contrario, simplemente ignora este correo y la solicitud se eliminará automáticamente en un par de semanas.</p>
            <a href="http://127.0.0.1:8000/confirmar-suscripcion/{{$token}}" class="btn btn-outline-light">Confirmar suscripción</a>
        </div>
        <div class="card-footer text-body-secondary">
            Si el botón no funciona, copia y pega el siguiente link en tu navegador: http://127.0.0.1:8000/confirmar-suscripcion/{{$token}}
        </div>
    </div>
</div>
</div>
</body>
</html>


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

<div id="correo" class="ms-2 me-2">
    <p></p>
    <p>Saludos. Nos comunicamos con usted porque hemos recibido una solicitud para suscribirse al Newsletter de nuestro sitio, la cual ha expirado, ya que no ha sido activada en un periodo de 30 días.</p>
    <p>Puede volver a solicitar una suscripción cuando lo desee en la página de inicio de nuestro sitio.</p>
    <p>Saludos cordiales.</p>
</div>
</body>
</html>


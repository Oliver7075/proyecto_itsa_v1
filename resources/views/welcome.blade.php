<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ITSA') }}</title>
    <link rel="stylesheet" href="{{ asset('css/itsa-theme.css') }}">
</head>
<body class="itsa-welcome">
    <main class="itsa-welcome-card">
        <img class="itsa-welcome-logo" src="{{ config('adminlte.logo_img') }}" alt="{{ config('adminlte.logo_img_alt', 'ITSA') }}">
        <h1>{{ config('app.name', 'ITSA') }}</h1>
        <p>Plataforma de gestión académica e institucional.</p>
        @auth
            <a class="btn" href="{{ route('home') }}">Ir al panel</a>
        @else
            <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
        @endauth
    </main>
</body>
</html>

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido a mi Panel de Control</h1>
@stop

@section('content')
    <p>Este es el cuerpo de mi aplicación usando AdminLTE en Laravel 12.</p>
@stop

@section('css')
    {{-- Aquí puedes agregar CSS personalizado si lo necesitas --}}
@stop

@section('js')
    <script> console.log('¡Hola Mundo!'); </script>
@stop
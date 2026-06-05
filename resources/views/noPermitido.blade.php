@extends('layouts.publico')

@section('titulo', 'Sin permisos')

@section('contenido')
<section class="py-5 seccion-con-navbar">
    <div class="container text-center">
        <i class="bi bi-shield-lock icono-xxl" aria-hidden="true"></i>
        <h1 class="titulo-serif mt-3">Acceso no permitido</h1>
        <p class="lead text-muted">Lo sentimos, no tienes permisos para entrar en esta zona.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
            <i class="bi bi-house"></i> Volver al inicio
        </a>
    </div>
</section>
@endsection

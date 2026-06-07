@extends('layouts.publico')

@section('titulo', $habitacion->tipo . ' Nº ' . $habitacion->numero)

@section('contenido')

<section class="py-5 seccion-pt-navbar">
    <div class="container">

        {{-- BREADCRUMB --}}
        <nav aria-label="Migas de pan" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('habitaciones.catalogo') }}">Habitaciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $habitacion->tipo }} Nº {{ $habitacion->numero }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- 3 img que se muestran en todas las habitaciones. --}}
            <div class="col-lg-7">
                <div id="carouselHabitacion" class="carousel slide" data-bs-ride="carousel" aria-label="Galería de imágenes">

                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselHabitacion" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Imagen 1"></button>
                        <button type="button" data-bs-target="#carouselHabitacion" data-bs-slide-to="1"
                                aria-label="Imagen 2"></button>
                        <button type="button" data-bs-target="#carouselHabitacion" data-bs-slide-to="2"
                                aria-label="Imagen 3"></button>
                    </div>

                    {{-- Las 3 diapositivas (mismas fotos para todas las habitaciones) --}}
                    <div class="carousel-inner carousel-alto">
                        <div class="carousel-item carousel-alto active">
                            <img src="{{ asset('assets/img/habitaciones/suite.jpg') }}"
                                 class="d-block w-100 h-100 img-carousel"
                                 alt="Vista principal de la habitación">
                        </div>
                        <div class="carousel-item carousel-alto">
                            <img src="{{ asset('assets/img/habitaciones/suite2.jpg') }}"
                                 class="d-block w-100 h-100 img-carousel"
                                 alt="Vista 2 de la habitación">
                        </div>
                        <div class="carousel-item carousel-alto">
                            <img src="{{ asset('assets/img/habitaciones/suite3.jpg') }}"
                                 class="d-block w-100 h-100 img-carousel"
                                 alt="Vista 3 de la habitación">
                        </div>
                    </div>

                    {{-- Flechas de anterior/siguiente --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselHabitacion" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselHabitacion" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>

            {{-- ============ INFO + RESERVA ============ --}}
            <div class="col-lg-5">
                <p class="text-uppercase text-muted section-tag">— {{ $habitacion->tipo }} —</p>
                <h1 class="titulo-serif">Habitación Nº {{ $habitacion->numero }}</h1>
                <div class="divider-decoration justify-content-start ms-0">
                    <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
                </div>

                <p class="lead">
                    {{ $habitacion->descripcion ?? 'Habitación elegante con todas las comodidades del Grand Hotel Continental.' }}
                </p>

                {{-- Datos clave --}}
                <div class="row g-3 my-4">
                    <div class="col-6">
                        <div class="p-3 text-center box-info-beige">
                            <i class="bi bi-door-closed icono-md-15 text-oro" aria-hidden="true"></i>
                            <p class="small text-muted mb-0 mt-2">Número</p>
                            <strong>{{ $habitacion->numero }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 text-center box-info-beige">
                            <i class="bi bi-tag icono-md-15 text-oro" aria-hidden="true"></i>
                            <p class="small text-muted mb-0 mt-2">Tipo</p>
                            <strong>{{ $habitacion->tipo }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Precio --}}
                <div class="p-4 text-center mb-3 box-precio-oscuro">
                    <p class="small text-uppercase mb-1 label-precio">Precio por noche</p>
                    <h2 class="titulo-serif text-white text-oro-fuerte mb-0">
                        {{ number_format($habitacion->precio, 2, ',', '.') }} €
                    </h2>
                </div>

                {{-- Botón reservar: solo visible para clientes (idRol = 3).
                     Admins y recepcionistas no se reservan a sí mismos,
                     usan el panel /admin/reservas/crear con un cliente. --}}
                @auth
                    @if(auth()->user()->idRol == 3)
                        <a href="{{ route('reservar.form', $habitacion->id) }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-calendar-plus" aria-hidden="true"></i> Reservar esta habitación
                        </a>
                    @else
                        <div class="alert alert-info text-center mb-2" role="alert">
                            <i class="bi bi-info-circle" aria-hidden="true"></i>
                            Como personal del hotel, las reservas se crean desde el panel a nombre de un cliente.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Inicia sesión para reservar
                    </a>
                @endauth

                <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Volver al catálogo
                </a>
            </div>
        </div>

        {{-- ============ SERVICIOS INCLUIDOS ============ --}}
        <div class="mt-5 pt-4 border-top">
            <h3 class="titulo-serif text-center mb-4">
                <i class="bi bi-stars text-oro" aria-hidden="true"></i>
                Comodidades incluidas
            </h3>
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <i class="bi bi-wifi icono-md text-oro" aria-hidden="true"></i>
                    <p class="small mt-2 mb-0">Wi-Fi gratuito</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-tv icono-md text-oro" aria-hidden="true"></i>
                    <p class="small mt-2 mb-0">TV pantalla plana</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-snow icono-md text-oro" aria-hidden="true"></i>
                    <p class="small mt-2 mb-0">Aire acondicionado</p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-cup-hot icono-md text-oro" aria-hidden="true"></i>
                    <p class="small mt-2 mb-0">Servicio habitación</p>
                </div>
            </div>
        </div>

        {{-- ============ OPINIONES DE CLIENTES ============ --}}
        <div class="mt-5 pt-4 border-top">
            <h3 class="titulo-serif text-center mb-2">
                <i class="bi bi-chat-square-quote text-oro" aria-hidden="true"></i>
                Opiniones de huéspedes
            </h3>

            @php
                $opiniones = $habitacion->opiniones()
                              ->with('user')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
                $media = $habitacion->opiniones()->avg('puntuacion');
            @endphp

            @if($opiniones->count() > 0)
                <p class="text-center mb-4">
                    <strong class="subtitulo-tarjeta">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($media) ? 'bi-star-fill' : 'bi-star' }} text-estrella"></i>
                        @endfor
                    </strong>
                    <span class="ms-2 text-muted">{{ number_format($media, 1) }} / 5
                        ({{ $habitacion->opiniones()->count() }} opiniones)
                    </span>
                </p>

                <div class="row g-3">
                    @foreach($opiniones as $op)
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>{{ optional($op->user)->nombre }}</strong>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $op->puntuacion ? 'bi-star-fill' : 'bi-star' }} estrella-md"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="small text-muted mb-1">{{ \Carbon\Carbon::parse($op->created_at)->format('d/m/Y') }}</p>
                                    <p class="mb-0">{{ $op->comentario }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted mt-3">
                    <i class="bi bi-chat-square icono-md"></i><br>
                    Esta habitación aún no tiene opiniones.
                </p>
            @endif
        </div>

    </div>
</section>
@endsection

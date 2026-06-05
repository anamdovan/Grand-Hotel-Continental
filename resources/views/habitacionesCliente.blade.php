@extends('layouts.publico')

@section('titulo', 'Nuestras habitaciones')

@section('contenido')
<section class="py-5 seccion-pt-navbar">
    <div class="container">
        <p class="text-center text-uppercase text-muted section-tag">— Catálogo —</p>
        <h1 class="section-title">Nuestras habitaciones</h1>
        <div class="divider-decoration">
            <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
        </div>
        <p class="section-subtitle">Elige tu refugio y disfruta de una experiencia única en Bucarest</p>

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @auth
            <div class="alert alert-light border d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-info-circle me-2 text-oro" aria-hidden="true"></i>
                <div>
                    Hola <strong>{{ Auth::user()->nombre }}</strong>, haz clic en una habitación para ver detalles y reservar.
                </div>
            </div>
        @else
            <div class="alert alert-light border d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-info-circle me-2 text-oro" aria-hidden="true"></i>
                <div>
                    Para reservar necesitas tener una cuenta.
                    <a href="{{ route('login') }}" class="text-oro-oscuro">Inicia sesión</a> o
                    <a href="{{ route('formularioRegistro') }}" class="text-oro-oscuro">regístrate gratis</a>.
                </div>
            </div>
        @endauth

        <div class="row g-4">
            @forelse($habitaciones as $h)
                @php
                    // "Deluxe Twin" → "deluxe-twin"
                    $tipoSlug = \Illuminate\Support\Str::slug($h->tipo);
                    $rutaDetalle = route('habitaciones.detalle', $h->id);
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="card h-100">
                        {{-- La imagen y el título llevan al detalle --}}
                        <a href="{{ $rutaDetalle }}" class="text-decoration-none text-dark">
                            <img src="{{ asset('assets/img/habitaciones/' . $tipoSlug . '.jpg') }}"
                                 class="card-img-top"
                                 alt="Habitación {{ $h->tipo }}"
                                 onerror="this.src='{{ asset('assets/img/DELUXE-MATRIMONIALA-202-grand81344.jpg') }}';">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <a href="{{ $rutaDetalle }}" class="text-decoration-none text-dark">
                                <h3 class="card-title">{{ $h->tipo }}</h3>
                            </a>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-door-closed" aria-hidden="true"></i> Nº {{ $h->numero }}
                            </p>
                            <p class="card-text">
                                {{ Str::limit($h->descripcion ?? 'Habitación elegante con todas las comodidades del Grand Hotel Continental.', 100) }}
                            </p>
                            <p class="mb-3 mt-auto">
                                <strong class="precio-habitacion">
                                    {{ number_format($h->precio, 2, ',', '.') }} €
                                </strong>
                                <small class="text-muted">/ noche</small>
                            </p>

                            <div class="d-grid gap-2">
                                <a href="{{ $rutaDetalle }}"
                                   class="btn btn-outline-primary"
                                   data-bs-toggle="tooltip"
                                   title="Ver galería e información completa">
                                    <i class="bi bi-eye" aria-hidden="true"></i> Ver detalles
                                </a>
                                {{-- Solo los clientes (idRol = 3) pueden reservar desde aquí.
                                     Admins y recepcionistas reservan a nombre de un cliente
                                     desde el panel /admin/reservas/crear. --}}
                                @auth
                                    @if(auth()->user()->idRol == 3)
                                        <a href="{{ route('reservar.form', $h->id) }}"
                                           class="btn btn-primary">
                                            <i class="bi bi-calendar-plus" aria-hidden="true"></i> Reservar
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-door-closed icono-servicio" aria-hidden="true"></i>
                    <p class="mt-3 text-muted">No hay habitaciones disponibles ahora mismo.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@extends('layouts.publico')

@section('titulo', 'Grand Hotel Continental - Lujo en Bucarest')

@section('contenido')

{{-- ==================== CAROUSEL HERO ==================== --}}
<section aria-label="Galería principal" class="position-relative">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Diapositiva 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Diapositiva 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Diapositiva 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/img/Grand-Hotel-Continental-IMG_4054.jpg') }}"
                     class="d-block w-100" alt="Fachada del Grand Hotel Continental">
                <div class="carousel-caption">
                    <h3 class="titulo-serif fade-up">Libera tu imaginación</h3>
                    <div class="divider"></div>
                    <p class="lead">En el corazón histórico de Bucarest</p>
                    <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-primary mt-3">Reservar ahora</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('assets/img/DELUXE-MATRIMONIALA-202-grand81344.jpg') }}"
                     class="d-block w-100" alt="Habitación deluxe del hotel">
                <div class="carousel-caption">
                    <h3 class="titulo-serif">Lujo y confort</h3>
                    <div class="divider"></div>
                    <p class="lead">Habitaciones diseñadas para una experiencia inolvidable</p>
                    <a href="#habitaciones" class="btn btn-primary mt-3">Ver habitaciones</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('assets/img/thaiCo-4.jpg') }}"
                     class="d-block w-100" alt="Interior elegante del hotel">
                <div class="carousel-caption">
                    <h3 class="titulo-serif">Una experiencia única</h3>
                    <div class="divider"></div>
                    <p class="lead">Tradición, elegancia y servicio excepcional</p>
                    <a href="#servicios" class="btn btn-primary mt-3">Nuestros servicios</a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>

{{-- ==================== BIENVENIDA ==================== --}}
<section class="py-5" aria-labelledby="bienvenida-titulo">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <p class="text-uppercase text-muted section-tag">— Bienvenido —</p>
                <h2 id="bienvenida-titulo" class="section-title section-title-grande text-start">
                    Grand Hotel<br>Continental
                </h2>
                <div class="divider-decoration justify-content-start ms-0">
                    <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
                </div>
                <p class="lead">
                    Un hotel boutique de 5 estrellas en el centro histórico de Bucarest,
                    en el hermoso bulevar Victoriei.
                </p>
                <p>
                    Más que un alojamiento, ofrecemos una <strong>experiencia única</strong>
                    que combina elegancia tradicional, lujo contemporáneo y un servicio
                    personalizado que cuida cada detalle de tu estancia.
                </p>

                <div class="row mt-4 g-3">
                    <div class="col-4 text-center">
                        <h3 class="titulo-serif text-oro">50+</h3>
                        <small class="text-muted text-uppercase tracking-tight">Habitaciones</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="titulo-serif text-oro">5★</h3>
                        <small class="text-muted text-uppercase tracking-tight">Categoría</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="titulo-serif text-oro">24h</h3>
                        <small class="text-muted text-uppercase tracking-tight">Recepción</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hotel-grand-continental2.jpg') }}"
                     class="img-fluid shadow-lg" alt="Vista del Grand Hotel Continental">
            </div>
        </div>
    </div>
</section>

{{-- ==================== HABITACIONES ==================== --}}
<section class="py-5 bg-beige-2" id="habitaciones" aria-labelledby="hab-titulo">
    <div class="container py-5">
        <p class="text-center text-uppercase text-muted section-tag">— Habitaciones —</p>
        <h2 id="hab-titulo" class="section-title">Nuestras estancias</h2>
        <div class="divider-decoration">
            <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
        </div>
        <p class="section-subtitle">Cada habitación es un refugio de elegancia y confort</p>

        <div class="row g-4 mt-3">
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('habitaciones.catalogo') }}" class="text-decoration-none text-dark">
                    <article class="card h-100">
                        <img src="{{ asset('assets/img/habitaciones/deluxe-matrimonial.jpg') }}"
                             class="card-img-top" alt="Habitación Deluxe Matrimonial"
                             onerror="this.src='{{ asset('assets/img/DELUXE-MATRIMONIALA-202-grand81344.jpg') }}';">
                        <div class="card-body">
                            <h3 class="card-title">Deluxe Matrimonial</h3>
                            <p class="text-muted small">DESDE 195€ / NOCHE</p>
                            <p class="card-text">Espacio refinado con vistas al bulevar, cama king-size y baño de mármol.</p>
                            <span class="btn btn-outline-primary">
                                Ver detalles <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="{{ route('habitaciones.catalogo') }}" class="text-decoration-none text-dark">
                    <article class="card h-100">
                        <img src="{{ asset('assets/img/habitaciones/suite.jpg') }}"
                             class="card-img-top" alt="Suite"
                             onerror="this.src='{{ asset('assets/img/thaiCo-4.jpg') }}';">
                        <div class="card-body">
                            <h3 class="card-title">Suite</h3>
                            <p class="text-muted small">DESDE 320€ / NOCHE</p>
                            <p class="card-text">Sala de estar separada, jacuzzi y servicio de mayordomo personalizado.</p>
                            <span class="btn btn-outline-primary">
                                Ver detalles <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="{{ route('habitaciones.catalogo') }}" class="text-decoration-none text-dark">
                    <article class="card h-100">
                        <img src="{{ asset('assets/img/habitaciones/deluxe-twin.jpg') }}"
                             class="card-img-top" alt="Habitación Deluxe Twin"
                             onerror="this.src='{{ asset('assets/img/imagenHotel.jpg') }}';">
                        <div class="card-body">
                            <h3 class="card-title">Deluxe Twin</h3>
                            <p class="text-muted small">DESDE 195€ / NOCHE</p>
                            <p class="card-text">Dos camas individuales con el mismo lujo. Perfecta para amigos o viajes de trabajo compartidos.</p>
                            <span class="btn btn-outline-primary">
                                Ver detalles <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SERVICIOS ==================== --}}
<section class="py-5" id="servicios" aria-labelledby="serv-titulo">
    <div class="container py-5">
        <p class="text-center text-uppercase text-muted section-tag">— Servicios —</p>
        <h2 id="serv-titulo" class="section-title">Una experiencia completa</h2>
        <div class="divider-decoration">
            <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
        </div>

        <div class="row g-4 mt-4 text-center">
            <div class="col-md-6 col-lg-3">
                <i class="bi bi-cup-hot icono-servicio" aria-hidden="true"></i>
                <h4 class="mt-3 titulo-serif titulo-servicio">Restaurante gourmet</h4>
                <p class="small text-muted">Cocina internacional de la mano de chef premiados.</p>
            </div>
            <div class="col-md-6 col-lg-3">
                <i class="bi bi-water icono-servicio" aria-hidden="true"></i>
                <h4 class="mt-3 titulo-serif titulo-servicio">Spa & Wellness</h4>
                <p class="small text-muted">Tratamientos relajantes en un entorno único.</p>
            </div>
            <div class="col-md-6 col-lg-3">
                <i class="bi bi-wifi icono-servicio" aria-hidden="true"></i>
                <h4 class="mt-3 titulo-serif titulo-servicio">Wi-Fi premium</h4>
                <p class="small text-muted">Conexión de alta velocidad en todo el hotel.</p>
            </div>
            <div class="col-md-6 col-lg-3">
                <i class="bi bi-car-front icono-servicio" aria-hidden="true"></i>
                <h4 class="mt-3 titulo-serif titulo-servicio">Parking y traslados</h4>
                <p class="small text-muted">Servicio de valet y transfer al aeropuerto.</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== UBICACIÓN Y CLIMA ==================== --}}
<section class="py-5" id="ubicacion" aria-labelledby="ubic-titulo">
    <div class="container">
        <p class="text-center text-uppercase text-muted section-tag">— Ubicación —</p>
        <h2 id="ubic-titulo" class="section-title">Encuéntranos en Bucarest</h2>
        <div class="divider-decoration">
            <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
        </div>

        <div class="row justify-content-center align-items-start g-4 mt-3">
            {{-- Clima --}}
            <div class="col-12 col-md-4 text-center">
                <a class="weatherwidget-io"
                   href="https://forecast7.com/en/44d4326d10/bucharest/"
                   data-label_1="BUCHAREST"
                   data-label_2="WEATHER"
                   data-theme="original">BUCHAREST WEATHER</a>
            </div>

            {{-- Mapa --}}
            <div class="col-12 col-md-8">
                <div class="ratio ratio-16x9">
                    <iframe class="border-0"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2848.8164114065535!2d26.0960337!3d44.436928!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b1ff4692326435%3A0xbc274961e289fdab!2sGrand%20Hotel%20Continental%20Bucharest!5e0!3m2!1ses!2ses!4v1743172672987!5m2!1ses!2ses"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mapa de ubicación del Grand Hotel Continental">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== TESTIMONIOS DE HUÉSPEDES ==================== --}}
@if(isset($opinionesDestacadas) && $opinionesDestacadas->count() > 0)
<section class="py-5 bg-beige">
    <div class="container py-4">
        <p class="text-uppercase text-muted text-center section-tag">— Testimonios —</p>
        <h2 class="titulo-serif text-center mb-2">Lo que dicen nuestros huéspedes</h2>
        <div class="text-center mb-5">
            <span class="fs-grande">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star-fill text-estrella" aria-hidden="true"></i>
                @endfor
            </span>
            <p class="text-muted mt-2">
                Opiniones reales de clientes que ya nos han visitado
            </p>
        </div>

        <div class="row g-4">
            @foreach($opinionesDestacadas as $op)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">

                            {{-- Cabecera: avatar + nombre + estrellas --}}
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle me-3 avatar-testimonio">
                                    <i class="bi bi-person-fill icono-avatar" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <strong class="d-block">{{ optional($op->user)->nombre ?? 'Huésped' }}</strong>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $op->puntuacion ? 'bi-star-fill' : 'bi-star' }} estrella-sm" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            {{-- Cita --}}
                            <i class="bi bi-quote icono-quote" aria-hidden="true"></i>
                            <p class="mb-3 fst-italic">{{ $op->comentario }}</p>

                            {{-- Pie: habitación + fecha --}}
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-door-open" aria-hidden="true"></i>
                                    {{ optional($op->habitacion)->tipo ?? 'Habitación' }}
                                </small>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($op->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ==================== CTA FINAL ==================== --}}
<section class="py-5 text-center bg-cta-oscuro">
    <div class="container py-4">
        <h2 class="titulo-serif text-white">¿Listo para una experiencia inolvidable?</h2>
        <p class="lead">Reserva tu estancia y descubre el verdadero lujo en Bucarest.</p>
        <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-primary mt-3">
            Reservar ahora <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>

@endsection

@section('js')
{{-- Cargador del widget del tiempo de weatherwidget.io (en JS aparte). --}}
<script src="{{ asset('assets/js/widgetTiempo.js') }}"></script>
@endsection

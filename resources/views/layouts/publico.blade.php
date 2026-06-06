
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Grand Hotel Continental - Hotel boutique de 5 estrellas en el corazón de Bucarest">

    {{-- @yield('titulo') → cada vista pone su propio título.
         El segundo argumento es el valor por defecto si la vista no define el bloque. --}}
    <title>@yield('titulo', 'Grand Hotel Continental - Lujo en Bucarest')</title>

    {{-- CSRF token: lo lee JS para incluirlo en peticiones AJAX
         protegidas. Laravel requiere este token en cada POST/PUT/DELETE. --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ORDEN de CSS: Bootstrap primero, fuentes, después nuestros estilos.
         El último gana en caso de conflicto → estilos.css y botones.css
         pueden sobrescribir Bootstrap. --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.0.2/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/botones.css') }}">

    {{-- @yield('css') → permite a cada vista añadir CSS extra si lo necesita --}}
    @yield('css')
</head>
<body>



{{-- ==================== NAVBAR (cabecera fija) ==================== --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" aria-label="Navegación principal">
        <div class="container">

            {{-- Logo + nombre --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" aria-label="Grand Hotel Continental - Inicio">
                <img src="{{ asset('assets/img/ch_symbol.svg') }}"
                     alt="Grand Hotel Continental"
                     height="45"
                     class="me-2">
                <span>GHC</span>
            </a>

            {{-- Botón hamburguesa para móvil. data-bs-toggle="collapse"
                 le dice a Bootstrap que al pulsarlo se abra/cierre el menú. --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navMenu" aria-controls="navMenu"
                    aria-expanded="false" aria-label="Abrir menú de navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                {{-- Enlaces principales del menú.
                     request()->is('habitaciones*') devuelve true si la URL
                     actual empieza por /habitaciones → resaltamos como activo. --}}
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('habitaciones*') ? 'active' : '' }}" href="{{ route('habitaciones.catalogo') }}">Habitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contacto') ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>

                {{-- Bloque derecho: cambia si el usuario está logueado o no --}}
                <ul class="navbar-nav align-items-lg-center">
                    {{-- @auth → solo se renderiza si hay sesión iniciada --}}
                    @auth
                        {{-- DROPDOWN del usuario: se abre al pasar el ratón (CSS).
                             En móvil/teclado funciona también con clic (Bootstrap). --}}
                        <li class="nav-item dropdown nav-user-dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center"
                               href="#"
                               id="menuUsuario"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="bi bi-person-circle me-1" aria-hidden="true"></i>
                                {{ Auth::user()->nombre ?? 'Mi cuenta' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuUsuario">
                                {{-- Mi cuenta (todos los usuarios logueados) --}}
                                <li>
                                    <a class="dropdown-item" href="{{ route('miCuenta') }}">
                                        <i class="bi bi-person" aria-hidden="true"></i> Mi cuenta
                                    </a>
                                </li>

                                {{-- Panel admin: SOLO para admin o recepcionista --}}
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('recepcionista'))
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/admin/dashboard') }}">
                                            <i class="bi bi-speedometer2" aria-hidden="true"></i>
                                            Panel de administración
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider"></li>

                                {{-- Cerrar sesión --}}
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Cerrar sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- @else → si no hay sesión, mostramos botones de login y reserva --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-lg-3" href="{{ route('habitaciones.catalogo') }}">
                                Reservar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>


{{-- ==================== CONTENIDO PRINCIPAL ==================== --}}
{{-- tabindex="-1" → para que el skip-link pueda dar foco a este elemento --}}
<main id="contenido-principal" tabindex="-1">
    {{-- AQUÍ va el contenido específico de cada página.
         Lo rellenan las vistas con @section('contenido') ... @endsection --}}
    @yield('contenido')
</main>


{{-- ==================== FOOTER ==================== --}}
<footer class="footer-custom mt-5" id="contacto" aria-labelledby="footer-titulo">
    {{-- visually-hidden → oculto visualmente pero accesible para lectores de pantalla --}}
    <h2 id="footer-titulo" class="visually-hidden">Información de contacto y enlaces</h2>

    <div class="container">
        <div class="row gy-4">

            {{-- Columna 1: descripción + redes --}}
            <div class="col-md-4">
                <h5>Grand Hotel Continental</h5>
                <p class="small">
                    Hotel boutique de 5 estrellas en el corazón histórico de Bucarest.
                    Una experiencia única de lujo, tradición y servicio personalizado.
                </p>
                <div class="mt-3">
                    <a href="https://www.facebook.com" class="social-link" aria-label="Facebook">
                        <i class="bi bi-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com" class="social-link" aria-label="Instagram">
                        <i class="bi bi-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="https://x.com" class="social-link" aria-label="X (Twitter)">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            {{-- Columna 2: contacto.
                 <address> es la etiqueta semántica HTML para info de contacto. --}}
            <div class="col-md-4">
                <h5>Contacto</h5>
                <address class="small fst-normal">
                    <p><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> 56, Victory Avenue<br>010083, Bucarest</p>
                    <p>
                        <i class="bi bi-telephone" aria-hidden="true"></i>
                        <a href="tel:+40372010300">+40 372 010 300</a>
                    </p>
                    <p>
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <a href="mailto:reservation@grandhotelcontinental.ro">reservation@grandhotelcontinental.ro</a>
                    </p>
                </address>
            </div>

            {{-- Columna 3: enlaces rápidos --}}
            <div class="col-md-4">
                <h5>Enlaces rápidos</h5>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right" aria-hidden="true"></i> Inicio</a></li>
                    <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right" aria-hidden="true"></i> Iniciar sesión</a></li>
                    <li><a href="{{ route('formularioRegistro') }}"><i class="bi bi-chevron-right" aria-hidden="true"></i> Registrarse</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">

        {{-- date('Y') → año actual (se actualiza solo cada año) --}}
        <p class="text-center small mb-0">© {{ date('Y') }} Grand Hotel Continental. Todos los derechos reservados.</p>
    </div>
</footer>


{{-- Botón "Volver arriba" flotante (posicionado por CSS abajo-derecha).
     El JS lo muestra solo cuando hay scroll > 200px. --}}
<button id="scrollToTopBtn"
        class="btn btn-primary scroll-to-top"
        type="button"
        aria-label="Volver al inicio de la página"
        title="Volver arriba">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>


{{-- ============================================================
     MODAL DE CONFIRMACIÓN
     Lo usa modalConfirmar.js para sustituir el confirm() del
     navegador por un modal Bootstrap (por ejemplo, al cancelar
     una reserva desde "Mi cuenta").
============================================================ --}}
<div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="modalConfirmarTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarTitulo">
                    <i class="bi bi-exclamation-triangle-fill text-error"></i>
                    Confirmar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="modalConfirmarMensaje" class="mb-0">
                    ¿Seguro que quieres continuar?
                </p>
                <p class="text-muted small mt-2 mb-0">
                    <i class="bi bi-info-circle"></i> Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancelar
                </button>
                <a href="#" id="modalConfirmarBtn" class="btn btn-danger">
                    <i class="bi bi-check-lg"></i> Sí, confirmar
                </a>
            </div>
        </div>
    </div>
</div>


{{-- ==================== JAVASCRIPT ====================
     IMPORTANTE: el orden de carga importa porque hay dependencias.
     Cada bloque depende de los anteriores. --}}

{{-- 1) Bootstrap → necesario para tooltips, popovers, dropdowns, modales, etc. --}}
<script src="{{ asset('vendor/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js') }}"></script>

{{-- 2) Auxiliares: funciones reutilizables (mostrarError, mostrarOk,
        validarEmail, validarPassword, validarNombre, etc.) --}}
<script src="{{ asset('assets/js/auxiliares.js') }}"></script>

{{-- 3) Botón ojo + arranque de tooltips/popovers de Bootstrap --}}
<script src="{{ asset('assets/js/togglePassword.js') }}"></script>

{{-- Botón "volver arriba" --}}
<script src="{{ asset('assets/js/scrollToTop.js') }}"></script>

{{-- Dropdown del usuario: abrir al pasar el ratón --}}
<script src="{{ asset('assets/js/dropdownHover.js') }}"></script>

{{-- Helper para el modal de confirmación (sustituye al confirm() nativo) --}}
<script src="{{ asset('assets/js/modalConfirmar.js') }}"></script>

{{-- @yield('js') → cada vista puede añadir JS específico al final --}}
@yield('js')

</body>
</html>

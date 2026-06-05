<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Administración') | Grand Hotel Continental</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.0.2/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/botones.css') }}">

    {{-- DataTables CSS (paginación, búsqueda, orden) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">

    {{-- Personalización de DataTables: paginación dorada en vez de azul --}}
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">

    @yield('css')
</head>
<body>

<div class="d-flex flex-column flex-md-row">
    {{-- SIDEBAR --}}
    <aside class="sidebar-admin" aria-label="Menú de administración">
        <a href="{{ url('/') }}" class="text-decoration-none d-block text-center mb-4">
            <img src="{{ asset('assets/img/ch_symbol.svg') }}"
                 alt="Grand Hotel Continental"
                 height="55"
                 class="mb-2">
            <h4 class="mb-0">GHC</h4>
            <small class="admin-panel-tag">ADMIN PANEL</small>
        </a>

        <nav>
            <ul class="nav flex-column mb-auto" role="menu">
                <li role="none">
                    <a href="{{ url('/admin/dashboard') }}"
                       class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Estadísticas y gráficas">
                        <i class="bi bi-graph-up" aria-hidden="true"></i> Dashboard
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/admin/reservas') }}"
                       class="nav-link {{ request()->is('admin/reservas*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Gestión de reservas">
                        <i class="bi bi-calendar-check" aria-hidden="true"></i> Reservas
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/admin/habitaciones') }}"
                       class="nav-link {{ request()->is('admin/habitaciones*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Gestión de habitaciones">
                        <i class="bi bi-door-closed" aria-hidden="true"></i> Habitaciones
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/admin/pagos') }}"
                       class="nav-link {{ request()->is('admin/pagos*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Histórico de pagos">
                        <i class="bi bi-cash-coin" aria-hidden="true"></i> Pagos
                    </a>
                </li>
                {{-- Servicios: solo lo ve el admin --}}
                @if(Auth::user() && Auth::user()->hasRole('admin'))
                <li role="none">
                    <a href="{{ url('/admin/servicios') }}"
                       class="nav-link {{ request()->is('admin/servicios*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Catálogo de servicios">
                        <i class="bi bi-stars" aria-hidden="true"></i> Servicios
                    </a>
                </li>
                @endif
                <li role="none">
                    <a href="{{ url('/admin/opiniones') }}"
                       class="nav-link {{ request()->is('admin/opiniones*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Opiniones de clientes">
                        <i class="bi bi-star-fill" aria-hidden="true"></i> Opiniones
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/admin/mensajes') }}"
                       class="nav-link {{ request()->is('admin/mensajes*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Bandeja de mensajes">
                        <i class="bi bi-envelope" aria-hidden="true"></i> Mensajes
                    </a>
                </li>
                {{-- Usuarios: solo lo ve el admin --}}
                @if(Auth::user() && Auth::user()->hasRole('admin'))
                <li role="none">
                    <a href="{{ url('/admin/usuarios') }}"
                       class="nav-link {{ request()->is('admin/usuarios*') ? 'active' : '' }}"
                       role="menuitem"
                       data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Gestión de usuarios">
                        <i class="bi bi-people" aria-hidden="true"></i> Usuarios
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <hr class="border-secondary mt-4">

        @auth
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center avatar-admin">
                    <i class="bi bi-person-fill" aria-hidden="true"></i>
                </div>
                <div class="text-start fs-sm">
                    <div>{{ Auth::user()->nombre ?? 'Usuario' }}</div>
                    <small class="text-grey">{{ Auth::user()->email }}</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="{{ url('/') }}">
                    <i class="bi bi-house" aria-hidden="true"></i> Ver web pública
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Cerrar sesión
                </a></li>
            </ul>
        </div>
        @endauth
    </aside>

    {{-- CONTENIDO --}}
    <main id="contenido-admin" class="flex-grow-1 p-4 p-md-5" tabindex="-1">
        {{-- BREADCRUMB --}}
        <nav aria-label="Migas de pan" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bi bi-house" aria-hidden="true"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/reservas') }}">Admin</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>

        @yield('contenido')
    </main>
</div>

{{-- Botón "Volver arriba" --}}
<button id="scrollToTopBtn"
        class="btn btn-primary scroll-to-top"
        type="button"
        aria-label="Volver al inicio de la página"
        title="Volver arriba">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
</button>

{{-- ============================================================
     MODAL REUTILIZABLE: Confirmación de eliminación
     ============================================================
     Se abre desde JS (función confirmarEliminacion).
     Cuando el usuario pulsa "Sí, eliminar", se redirige a la URL.
============================================================ --}}
<div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="modalConfirmarTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarTitulo">
                    <i class="bi bi-exclamation-triangle-fill text-error"></i>
                    Confirmar eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="modalConfirmarMensaje" class="mb-0">
                    ¿Seguro que quieres eliminar este registro?
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
                    <i class="bi bi-trash"></i> Sí, eliminar
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ==================== JAVASCRIPT ==================== --}}
{{-- Bootstrap --}}
<script src="{{ asset('vendor/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js') }}"></script>

{{-- jQuery + DataTables --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>

{{-- Botón ojo + arranque de tooltips/popovers de Bootstrap --}}
<script src="{{ asset('assets/js/togglePassword.js') }}"></script>

{{-- Botón volver arriba --}}
<script src="{{ asset('assets/js/scrollToTop.js') }}"></script>

{{-- Helper para el modal de confirmar eliminación --}}
<script src="{{ asset('assets/js/modalConfirmar.js') }}"></script>

@yield('js')

</body>
</html>

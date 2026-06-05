@extends('layouts.publico')

@section('titulo', 'Mi cuenta')

@section('contenido')
<section class="py-5 seccion-con-navbar-alto">
    <div class="container">

        {{-- Mensajes flash --}}
        @if(session('mensaje'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
                <div>{{ session('mensaje') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif


        <p class="text-uppercase text-muted section-tag">— Mi área personal —</p>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="titulo-serif mb-1">Hola, {{ Auth::user()->nombre ?? 'Bienvenido' }}</h1>
                <p class="text-muted mb-0">Gestiona tu cuenta y tus reservas desde aquí.</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                {{-- Botón que despliega el offcanvas con los datos personales --}}
                <button type="button" class="btn btn-outline-primary"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasDatos"
                        aria-controls="offcanvasDatos">
                    <i class="bi bi-person-circle" aria-hidden="true"></i> Mis datos
                </button>

                <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle" aria-hidden="true"></i> Nueva reserva
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h3 class="titulo-serif titulo-subseccion mb-3">
                    <i class="bi bi-calendar-check text-oro" aria-hidden="true"></i>
                    Mis reservas
                </h3>
                <hr>

                @if(Auth::user()->reservas && Auth::user()->reservas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr class="border-bottom">
                                    <th>Habitación</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->reservas as $r)
                                    <tr>
                                        <td>
                                            <strong>Nº {{ optional($r->habitacion)->numero }}</strong><br>
                                            <small class="text-muted">{{ optional($r->habitacion)->tipo }}</small>
                                            @if($r->servicios->count() > 0)
                                                <br>
                                                @foreach($r->servicios as $serv)
                                                    <span class="badge bg-light text-dark border fs-xs">
                                                        <i class="bi bi-plus-circle text-oro"></i> {{ $serv->nombre }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($r->fechaEntrada)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r->fechaSalida)->format('d/m/Y') }}</td>
                                        <td><strong>{{ number_format($r->total, 2, ',', '.') }} €</strong></td>
                                        <td>
                                            @switch($r->estado)
                                                @case('pendiente')   <span class="badge bg-warning">Pendiente</span>   @break
                                                @case('confirmada')  <span class="badge bg-info">Confirmada</span>     @break
                                                @case('cancelada')   <span class="badge bg-danger">Cancelada</span>    @break
                                                @case('completada')  <span class="badge bg-success">Completada</span>  @break
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            @if(!in_array($r->estado, ['cancelada', 'completada']))
                                                <a href="{{ route('reservar.cancelar', $r->id) }}"
                                                   class="btn btn-sm btn-outline-primary btn-eliminar"
                                                   data-bs-toggle="tooltip" title="Cancelar reserva"
                                                   onclick="return confirmarEliminacion(event, this.href, '¿Seguro que quieres cancelar esta reserva?');">
                                                    <i class="bi bi-x-circle" aria-hidden="true"></i>
                                                </a>
                                            @elseif($r->estado == 'completada' && !$r->opinion)
                                                <a href="{{ route('opinar.form', $r->id) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   data-bs-toggle="tooltip" title="Dejar opinión">
                                                    <i class="bi bi-star" aria-hidden="true"></i>
                                                </a>
                                            @elseif($r->estado == 'completada' && $r->opinion)
                                                <span class="badge bg-success" title="Ya opinaste"><i class="bi bi-check"></i></span>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x icono-grande" aria-hidden="true"></i>
                        <p class="mt-3 mb-3">Aún no tienes reservas.</p>
                        <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-primary">
                            Explorar habitaciones
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

{{-- ============================================================
    OFFCANVAS LATERAL CON DATOS PERSONALES
    Lleva la info personal del cliente
    y el botón de cerrar sesión.
============================================================ --}}
<div class="offcanvas offcanvas-end offcanvas-datos" tabindex="-1" id="offcanvasDatos"
     aria-labelledby="offcanvasDatosLabel">

    <div class="offcanvas-header bg-beige">
        <h5 class="offcanvas-title titulo-serif" id="offcanvasDatosLabel">
            <i class="bi bi-person-circle text-oro" aria-hidden="true"></i>
            Mis datos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <div class="offcanvas-body">

        {{-- Foto / avatar grande (placeholder) --}}
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle avatar-circular">
                <i class="bi bi-person-fill icono-servicio" aria-hidden="true"></i>
            </div>
            <h6 class="mt-3 mb-0">{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</h6>
            <small class="text-muted">Cliente</small>
        </div>

        {{-- Datos --}}
        <dl class="mb-4">
            <dt class="text-muted small text-uppercase mt-3 dt-etiqueta">
                <i class="bi bi-envelope" aria-hidden="true"></i> Email
            </dt>
            <dd class="ms-1">{{ Auth::user()->email }}</dd>

            <dt class="text-muted small text-uppercase mt-3 dt-etiqueta">
                <i class="bi bi-person" aria-hidden="true"></i> Nombre completo
            </dt>
            <dd class="ms-1">{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</dd>

            <dt class="text-muted small text-uppercase mt-3 dt-etiqueta">
                <i class="bi bi-telephone" aria-hidden="true"></i> Teléfono
            </dt>
            <dd class="ms-1">{{ Auth::user()->telefono ?? '—' }}</dd>

            <dt class="text-muted small text-uppercase mt-3 dt-etiqueta">
                <i class="bi bi-calendar-event" aria-hidden="true"></i> Miembro desde
            </dt>
            <dd class="ms-1">{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y') }}</dd>
        </dl>

        <hr>

        {{-- Acciones --}}
        <a href="{{ route('logout') }}" class="btn btn-outline-primary w-100 btn-eliminar">
            <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Cerrar sesión
        </a>

    </div>
</div>

@endsection

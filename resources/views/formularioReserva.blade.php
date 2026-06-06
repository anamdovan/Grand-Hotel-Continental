@extends('layouts.admin')

@section('titulo', isset($reserva) ? 'Editar reserva' : 'Nueva reserva')

@php
    $esEdicion = isset($reserva);
    $accion    = $esEdicion
                  ? url('/admin/reservas/editar/'.$reserva->id)
                  : url('/admin/reservas/crear');

    // Cliente preseleccionado en modo edición
    $clienteId    = $esEdicion ? $reserva->idUser : old('idUser', '');
    $clienteTexto = '';
    if ($esEdicion && $reserva->user) {
        $clienteTexto = $reserva->user->email;
    }
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/reservas') }}">Reservas</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $esEdicion ? 'Editar' : 'Nueva' }}</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-{{ $esEdicion ? 'pencil-square' : 'plus-circle' }} text-oro" aria-hidden="true"></i>
            {{ $esEdicion ? 'Editar reserva' : 'Nueva reserva' }}
        </h1>
        <p class="text-muted mb-0">{{ $esEdicion ? 'Modifica los datos de la reserva' : 'Crea una nueva reserva para un cliente' }}</p>
    </div>
    <a href="{{ url('/admin/reservas') }}" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> Volver
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body p-4 p-md-5">
        <form action="{{ $accion }}" method="POST" id="formReserva" novalidate>
            @csrf

            <div class="row g-3">
                {{-- ============ CLIENTE (desplegable) ============ --}}
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="idUser" id="idUser" class="form-select" required>
                            <option value="" disabled {{ empty($clienteId) ? 'selected' : '' }}>Selecciona un cliente...</option>
                            @foreach($users->where('idRol', 3) as $u)
                                <option value="{{ $u->id }}" {{ $clienteId == $u->id ? 'selected' : '' }}>
                                    {{ $u->email }}
                                </option>
                            @endforeach
                        </select>
                        <label for="idUser"><i class="bi bi-person" aria-hidden="true"></i> Cliente *</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="idHabitacion" id="idHabitacion" class="form-select" required>
                            @php $habActual = old('idHabitacion', $reserva->idHabitacion ?? ''); @endphp
                            <option value="" disabled {{ empty($habActual) ? 'selected' : '' }}>Selecciona habitación...</option>
                            @foreach($habitaciones as $h)
                                <option value="{{ $h->id }}" {{ $habActual == $h->id ? 'selected' : '' }}>
                                    Nº {{ $h->numero }} - {{ $h->tipo }} ({{ $h->precio }} €/noche)
                                </option>
                            @endforeach
                        </select>
                        <label for="idHabitacion"><i class="bi bi-door-closed" aria-hidden="true"></i> Habitación *</label>
                    </div>
                </div>
            </div>

            {{--
                Atributo min="{{ date('Y-m-d') }}" bloquea fechas pasadas
                desde el propio navegador (el calendario gris las pasadas).
                Solo en modo CREAR: si estamos editando una reserva que ya
                era de fecha pasada, hay que dejarla editar sin forzar a
                cambiarla.
            --}}
            @php $minFecha = !isset($reserva) ? date('Y-m-d') : null; @endphp

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control"
                               value="{{ old('fechaEntrada', isset($reserva) ? \Carbon\Carbon::parse($reserva->fechaEntrada)->format('Y-m-d') : '') }}"
                               @if($minFecha) min="{{ $minFecha }}" @endif
                               required>
                        <label for="fechaEntrada"><i class="bi bi-calendar-plus" aria-hidden="true"></i> Entrada *</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" name="fechaSalida" id="fechaSalida" class="form-control"
                               value="{{ old('fechaSalida', isset($reserva) ? \Carbon\Carbon::parse($reserva->fechaSalida)->format('Y-m-d') : '') }}"
                               @if($minFecha) min="{{ $minFecha }}" @endif
                               required>
                        <label for="fechaSalida"><i class="bi bi-calendar-minus" aria-hidden="true"></i> Salida *</label>
                    </div>
                </div>
            </div>

            @if($esEdicion)
                <div class="form-floating mt-3">
                    <select name="estado" id="estado" class="form-select" required>
                        @php $estadoActual = old('estado', $reserva->estado); @endphp
                        <option value="pendiente"  {{ $estadoActual=='pendiente'  ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmada" {{ $estadoActual=='confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="cancelada"  {{ $estadoActual=='cancelada'  ? 'selected' : '' }}>Cancelada</option>
                        <option value="completada" {{ $estadoActual=='completada' ? 'selected' : '' }}>Completada</option>
                    </select>
                    <label for="estado"><i class="bi bi-toggle-on" aria-hidden="true"></i> Estado *</label>
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ url('/admin/reservas') }}" class="btn btn-outline-primary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> {{ $esEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

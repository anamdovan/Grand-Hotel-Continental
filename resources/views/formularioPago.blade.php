@extends('layouts.admin')

@section('titulo', isset($pago) ? 'Editar pago' : 'Nuevo pago')

@php
    $esEdicion = isset($pago);
    $accion    = $esEdicion
                  ? url('/admin/pagos/editar/'.$pago->id)
                  : url('/admin/pagos/crear');
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/pagos') }}">Pagos</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $esEdicion ? 'Editar' : 'Nuevo' }}</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-{{ $esEdicion ? 'pencil-square' : 'plus-circle' }} text-oro" aria-hidden="true"></i>
            {{ $esEdicion ? 'Editar pago' : 'Nuevo pago' }}
        </h1>
        <p class="text-muted mb-0">{{ $esEdicion ? 'Modifica los datos del pago' : 'Registra un nuevo pago para una reserva' }}</p>
    </div>
    <a href="{{ url('/admin/pagos') }}" class="btn btn-outline-primary">
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
        <form action="{{ $accion }}" method="POST" id="formPago" novalidate>
            @csrf

            <div class="form-floating">
                <select name="idReserva" id="idReserva" class="form-select" required>
                    <option value="" disabled selected>Selecciona reserva...</option>
                    @php $resActual = old('idReserva', $pago->idReserva ?? ''); @endphp
                    @foreach($reservas as $r)
                        <option value="{{ $r->id }}" {{ $resActual == $r->id ? 'selected' : '' }}>
                            Reserva #{{ $r->id }} -
                            {{ optional($r->user)->nombre }} -
                            Hab. {{ optional($r->habitacion)->numero }}
                            ({{ number_format($r->total, 2, ',', '.') }} €)
                        </option>
                    @endforeach
                </select>
                <label for="idReserva"><i class="bi bi-calendar-check" aria-hidden="true"></i> Reserva *</label>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" step="0.01" min="0" name="monto" id="monto" class="form-control"
                               placeholder="0.00"
                               value="{{ old('monto', $pago->monto ?? '') }}" required>
                        <label for="monto"><i class="bi bi-currency-euro" aria-hidden="true"></i> Monto *</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="metodo" id="metodo" class="form-select" required>
                            @php $metActual = old('metodo', $pago->metodo ?? ''); @endphp
                            <option value="" disabled {{ $metActual==''?'selected':'' }}>Selecciona...</option>
                            <option value="tarjeta"       {{ $metActual=='tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                            <option value="efectivo"      {{ $metActual=='efectivo'      ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ $metActual=='transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="paypal"        {{ $metActual=='paypal'        ? 'selected' : '' }}>PayPal</option>
                        </select>
                        <label for="metodo"><i class="bi bi-credit-card" aria-hidden="true"></i> Método *</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mt-3">
                <select name="estado" id="estado" class="form-select" required>
                    @php $estActual = old('estado', $pago->estado ?? 'pendiente'); @endphp
                    <option value="pendiente"  {{ $estActual=='pendiente'  ? 'selected' : '' }}>Pendiente</option>
                    <option value="completado" {{ $estActual=='completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado"  {{ $estActual=='cancelado'  ? 'selected' : '' }}>Cancelado</option>
                </select>
                <label for="estado"><i class="bi bi-toggle-on" aria-hidden="true"></i> Estado *</label>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ url('/admin/pagos') }}" class="btn btn-outline-primary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> {{ $esEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


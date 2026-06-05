@extends('layouts.admin')

@section('titulo', isset($habitacion) ? 'Editar habitación' : 'Nueva habitación')

@php
    $esEdicion = isset($habitacion);
    $accion    = $esEdicion
                  ? url('/admin/habitaciones/editar/'.$habitacion->id)
                  : url('/admin/habitaciones/crear');
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/habitaciones') }}">Habitaciones</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $esEdicion ? 'Editar' : 'Nueva' }}</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-{{ $esEdicion ? 'pencil-square' : 'plus-circle' }} text-oro" aria-hidden="true"></i>
            {{ $esEdicion ? 'Editar habitación' : 'Nueva habitación' }}
        </h1>
        <p class="text-muted mb-0">{{ $esEdicion ? 'Modifica los datos existentes' : 'Añade una nueva habitación al catálogo' }}</p>
    </div>
    <a href="{{ url('/admin/habitaciones') }}" class="btn btn-outline-primary">
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
        <form action="{{ $accion }}" method="POST" id="formHabitacion" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="numero" id="numero" class="form-control"
                               placeholder="Número de habitación"
                               value="{{ old('numero', $habitacion->numero ?? '') }}" required>
                        <label for="numero">
                            <i class="bi bi-123" aria-hidden="true"></i> Número *
                        </label>
                        <div class="invalid-feedback">El número es obligatorio.</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="tipo" id="tipo" class="form-select" required>
                            @php $tipoActual = old('tipo', $habitacion->tipo ?? ''); @endphp
                            <option value="" disabled {{ $tipoActual==''?'selected':'' }}>Selecciona...</option>
                            <option value="Estándar"            {{ $tipoActual=='Estándar'            ? 'selected' : '' }}>Estándar</option>
                            <option value="Doble"               {{ $tipoActual=='Doble'               ? 'selected' : '' }}>Doble</option>
                            <option value="Deluxe Matrimonial"  {{ $tipoActual=='Deluxe Matrimonial'  ? 'selected' : '' }}>Deluxe Matrimonial</option>
                            <option value="Deluxe Twin"         {{ $tipoActual=='Deluxe Twin'         ? 'selected' : '' }}>Deluxe Twin</option>
                            <option value="Suite"               {{ $tipoActual=='Suite'               ? 'selected' : '' }}>Suite</option>
                            <option value="Suite Presidencial"  {{ $tipoActual=='Suite Presidencial'  ? 'selected' : '' }}>Suite Presidencial</option>
                        </select>
                        <label for="tipo"><i class="bi bi-tag" aria-hidden="true"></i> Tipo *</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" step="0.01" min="0" name="precio" id="precio" class="form-control"
                               placeholder="0.00"
                               value="{{ old('precio', $habitacion->precio ?? '') }}" required>
                        <label for="precio">
                            <i class="bi bi-currency-euro" aria-hidden="true"></i> Precio/noche *
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-floating mt-3">
                <select name="estado" id="estado" class="form-select" required>
                    @php $estadoActual = old('estado', $habitacion->estado ?? 'disponible'); @endphp
                    <option value="disponible"    {{ $estadoActual=='disponible'    ? 'selected' : '' }}>Disponible</option>
                    <option value="ocupada"       {{ $estadoActual=='ocupada'       ? 'selected' : '' }}>Ocupada</option>
                    <option value="mantenimiento" {{ $estadoActual=='mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                </select>
                <label for="estado"><i class="bi bi-toggle-on" aria-hidden="true"></i> Estado *</label>
            </div>

            <div class="form-floating mt-3">
                <textarea name="descripcion" id="descripcion" class="form-control textarea-md"
                          placeholder="Descripción">{{ old('descripcion', $habitacion->descripcion ?? '') }}</textarea>
                <label for="descripcion"><i class="bi bi-card-text" aria-hidden="true"></i> Descripción</label>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ url('/admin/habitaciones') }}" class="btn btn-outline-primary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> {{ $esEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


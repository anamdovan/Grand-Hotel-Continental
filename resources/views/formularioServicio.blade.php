@extends('layouts.admin')

@section('titulo', isset($servicio) ? 'Editar servicio' : 'Nuevo servicio')

@php
    $esEdicion = isset($servicio);
    $accion    = $esEdicion
                  ? url('/admin/servicios/editar/'.$servicio->id)
                  : url('/admin/servicios/crear');
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/servicios') }}">Servicios</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $esEdicion ? 'Editar' : 'Nuevo' }}</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-{{ $esEdicion ? 'pencil-square' : 'plus-circle' }} text-oro" aria-hidden="true"></i>
            {{ $esEdicion ? 'Editar servicio' : 'Nuevo servicio' }}
        </h1>
        <p class="text-muted mb-0">{{ $esEdicion ? 'Modifica los datos del servicio' : 'Añade un nuevo servicio al catálogo' }}</p>
    </div>
    <a href="{{ url('/admin/servicios') }}" class="btn btn-outline-primary">
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
        <form action="{{ $accion }}" method="POST" id="formServicio" novalidate>
            @csrf

            <div class="form-floating">
                <input type="text" name="nombre" id="nombre" class="form-control"
                       placeholder="Nombre del servicio"
                       value="{{ old('nombre', $servicio->nombre ?? '') }}" required>
                <label for="nombre"><i class="bi bi-tag" aria-hidden="true"></i> Nombre *</label>
                <div class="invalid-feedback">El nombre es obligatorio.</div>
            </div>

            <div class="form-floating mt-3">
                <textarea name="descripcion" id="descripcion" class="form-control textarea-lg"
                          placeholder="Descripción">{{ old('descripcion', $servicio->descripcion ?? '') }}</textarea>
                <label for="descripcion"><i class="bi bi-card-text" aria-hidden="true"></i> Descripción</label>
            </div>

            <div class="form-floating mt-3">
                <input type="number" step="0.01" min="0" name="precio" id="precio" class="form-control"
                       placeholder="0.00"
                       value="{{ old('precio', $servicio->precio ?? '') }}" required>
                <label for="precio"><i class="bi bi-currency-euro" aria-hidden="true"></i> Precio *</label>
                <div class="invalid-feedback">Introduce un precio válido.</div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ url('/admin/servicios') }}" class="btn btn-outline-primary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> {{ $esEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


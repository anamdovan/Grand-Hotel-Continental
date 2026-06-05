@extends('layouts.admin')

@section('titulo', 'Habitaciones')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Habitaciones</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-door-closed text-oro" aria-hidden="true"></i>
            Habitaciones
        </h1>
        <p class="text-muted mb-0">Gestiona el catálogo de habitaciones del hotel</p>
    </div>
    <a href="{{ url('/admin/habitaciones/crear') }}"
       class="btn btn-primary"
       data-bs-toggle="tooltip"
       title="Crear una nueva habitación">
        <i class="bi bi-plus-circle" aria-hidden="true"></i> Nueva habitación
    </a>
</div>

@if(session('mensaje'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>
        <div>{{ session('mensaje') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

<div class="card">
    <div class="card-body">
        {{-- Pasamos las URLs y el rol del usuario al JS mediante data-attributes --}}
        <table id="tablaHabitaciones" class="table table-hover tabla-completa"
               data-idioma="{{ asset('assets/json/datatables-es.json') }}"
               data-api="{{ url('/api/habitaciones') }}"
               data-editar="{{ url('/admin/habitaciones/editar') }}"
               data-borrar="{{ url('/admin/habitaciones/eliminar') }}"
               data-es-admin="{{ Auth::user() && Auth::user()->hasRole('admin') ? '1' : '' }}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Precio/noche</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- DataTables lo rellena automáticamente vía AJAX --}}
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
{{-- Lógica de la tabla de habitaciones separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableHabitaciones.js') }}"></script>
@endsection

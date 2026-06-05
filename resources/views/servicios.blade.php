@extends('layouts.admin')

@section('titulo', 'Servicios')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Servicios</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-stars text-oro" aria-hidden="true"></i>
            Servicios
        </h1>
        <p class="text-muted mb-0">Catálogo de servicios adicionales del hotel</p>
    </div>
    <a href="{{ url('/admin/servicios/crear') }}" class="btn btn-primary"
       data-bs-toggle="tooltip" title="Añadir nuevo servicio">
        <i class="bi bi-plus-circle" aria-hidden="true"></i> Nuevo servicio
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            {{-- Pasamos las URLs al JS mediante data-attributes --}}
            <table id="tablaServicios" class="table mb-0" aria-label="Listado de servicios"
                   data-api="{{ url('/api/servicios') }}"
                   data-editar="{{ url('/admin/servicios/editar') }}"
                   data-borrar="{{ url('/admin/servicios/eliminar') }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                {{-- Tbody vacío que rellena el JS con AJAX --}}
                <tbody id="tabla-servicios">
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="spinner-border spinner-oro" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 mb-0">Cargando servicios...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('js')
{{-- Lógica de la tabla de servicios separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableServicios.js') }}"></script>
@endsection

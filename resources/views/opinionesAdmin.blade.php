@extends('layouts.admin')

@section('titulo', 'Opiniones')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Opiniones</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-star-fill text-oro" aria-hidden="true"></i>
            Opiniones de clientes
        </h1>
        <p class="text-muted mb-0">Modera las valoraciones de los huéspedes</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Pasamos las URLs y el rol del usuario al JS mediante data-attributes --}}
        <table id="tablaOpiniones" class="table table-hover tabla-completa"
               data-idioma="{{ asset('assets/json/datatables-es.json') }}"
               data-api="{{ url('/api/opiniones') }}"
               data-borrar="{{ url('/admin/opiniones/eliminar') }}"
               data-es-admin="{{ Auth::user() && Auth::user()->hasRole('admin') ? '1' : '' }}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Puntuación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
{{-- Lógica de la tabla de opiniones separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableOpiniones.js') }}"></script>
@endsection

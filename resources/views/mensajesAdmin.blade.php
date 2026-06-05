@extends('layouts.admin')

@section('titulo', 'Mensajes')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Mensajes</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-envelope text-oro" aria-hidden="true"></i>
            Bandeja de mensajes
        </h1>
        <p class="text-muted mb-0">Mensajes del formulario público de contacto</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- Pasamos las URLs y el rol del usuario al JS mediante data-attributes --}}
        <table id="tablaMensajes" class="table table-hover tabla-completa"
               data-idioma="{{ asset('assets/json/datatables-es.json') }}"
               data-api="{{ url('/api/mensajes') }}"
               data-responder="{{ url('/admin/mensajes/responder') }}"
               data-borrar="{{ url('/admin/mensajes/eliminar') }}"
               data-es-admin="{{ Auth::user() && Auth::user()->hasRole('admin') ? '1' : '' }}">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Remitente</th>
                    <th>Contacto</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
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
{{-- Lógica de la tabla de mensajes separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableMensajes.js') }}"></script>
@endsection

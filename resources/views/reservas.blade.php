@extends('layouts.admin')

@section('titulo', 'Reservas')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Reservas</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-calendar-check text-oro" aria-hidden="true"></i>
            Reservas
        </h1>
        <p class="text-muted mb-0">Gestiona todas las reservas del hotel</p>
    </div>
    <a href="{{ url('/admin/reservas/crear') }}" class="btn btn-primary"
       data-bs-toggle="tooltip" title="Crear una nueva reserva">
        <i class="bi bi-plus-circle" aria-hidden="true"></i> Nueva reserva
    </a>
</div>

<div class="card">
    <div class="card-body">
        {{-- Pasamos las URLs al JS mediante data-attributes --}}
        <table id="tablaReservas" class="table table-hover tabla-completa"
               data-idioma="{{ asset('assets/json/datatables-es.json') }}"
               data-api="{{ url('/api/reservas') }}"
               data-editar="{{ url('/admin/reservas/editar') }}"
               data-borrar="{{ url('/admin/Sreservas/eliminar') }}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
{{-- Lógica de la tabla de reservas separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableReservas.js') }}"></script>
@endsection

@extends('layouts.admin')

@section('titulo', 'Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-people text-oro" aria-hidden="true"></i>
            Usuarios
        </h1>
        <p class="text-muted mb-0">Gestiona los usuarios del sistema y sus roles</p>
    </div>
    <a href="{{ url('/admin/usuarios/crear') }}"
       class="btn btn-primary"
       data-bs-toggle="tooltip"
       title="Dar de alta a un nuevo usuario">
        <i class="bi bi-plus-circle" aria-hidden="true"></i> Nuevo usuario
    </a>
</div>


<div class="card">
    <div class="card-body">
        {{-- Pasamos las URLs y el id del usuario logueado al JS mediante
             data-attributes. Así el script externo no necesita PHP --}}
        <table id="tablaUsuarios" class="table table-hover tabla-completa"
               data-idioma="{{ asset('assets/json/datatables-es.json') }}"
               data-api="{{ url('/api/usuarios') }}"
               data-editar="{{ url('/admin/usuarios/editar') }}"
               data-borrar="{{ url('/admin/usuarios/eliminar') }}"
               data-usuario-id="{{ Auth::id() ?? '' }}">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- DataTables lo rellena vía AJAX --}}
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
{{-- Lógica de la tabla de usuarios separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/datatableUsuarios.js') }}"></script>
@endsection

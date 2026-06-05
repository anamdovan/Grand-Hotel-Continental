@extends('layouts.admin')

@section('titulo', $usuario ? 'Editar usuario' : 'Crear usuario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/admin/usuarios') }}">Usuarios</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        {{ $usuario ? 'Editar' : 'Crear' }}
    </li>
@endsection

@section('contenido')
<div class="d-flex align-items-center mb-4">
    <a href="{{ url('/admin/usuarios') }}"
       class="btn btn-outline-secondary me-3"
       data-bs-toggle="tooltip"
       title="Volver al listado">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi {{ $usuario ? 'bi-pencil-square' : 'bi-person-plus' }} text-oro"
               aria-hidden="true"></i>
            {{ $usuario ? 'Editar usuario' : 'Nuevo usuario' }}
        </h1>
        <p class="text-muted mb-0">
            {{ $usuario ? 'Modifica los datos del usuario seleccionado' : 'Da de alta un usuario en el sistema' }}
        </p>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Hay errores en el formulario:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">

        {{-- Si $usuario existe → modo EDITAR. Si no → modo CREAR. --}}
        <form method="POST"
              action="{{ $usuario ? url('/admin/usuarios/editar/' . $usuario->id) : url('/admin/usuarios/crear') }}">
            @csrf

            <div class="row g-3">

                {{-- Nombre --}}
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre"
                           class="form-control"
                           value="{{ old('nombre', $usuario->nombre ?? '') }}"
                           required maxlength="100">
                </div>

                {{-- Apellidos --}}
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" id="apellidos"
                           class="form-control"
                           value="{{ old('apellidos', $usuario->apellidos ?? '') }}"
                           required maxlength="100">
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                           class="form-control"
                           value="{{ old('email', $usuario->email ?? '') }}"
                           required>
                </div>

                {{-- Teléfono --}}
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono"
                           class="form-control"
                           value="{{ old('telefono', $usuario->telefono ?? '') }}"
                           maxlength="20">
                </div>

                {{-- Rol --}}
                <div class="col-md-6">
                    <label for="idRol" class="form-label">Rol <span class="text-danger">*</span></label>
                    <select name="idRol" id="idRol" class="form-select" required>
                        <option value="">— Selecciona un rol —</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}"
                                {{ old('idRol', $usuario->idRol ?? '') == $rol->id ? 'selected' : '' }}>
                                {{ ucfirst($rol->tipoRol) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Contraseña --}}
                <div class="col-md-6">
                    <label for="password" class="form-label">
                        Contraseña {!! $usuario ? '<small class="text-muted">(dejar en blanco para no cambiar)</small>' : '<span class="text-danger">*</span>' !!}
                    </label>
                    <input type="password" name="password" id="password"
                           class="form-control"
                           minlength="8"
                           {{ $usuario ? '' : 'required' }}>
                    <small class="text-muted">Mínimo 8 caracteres.</small>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ url('/admin/usuarios') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    {{ $usuario ? 'Guardar cambios' : 'Crear usuario' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

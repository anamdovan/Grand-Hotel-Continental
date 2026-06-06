@extends('layouts.publico')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<section class="py-5 seccion-auth">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="auth-card fade-up">

                    <h2 class="titulo-serif"><i class="bi bi-lock" aria-hidden="true"></i> Bienvenido</h2>
                    <div class="divider-oro"></div>
                    <p class="text-center text-muted mb-4">Inicia sesión para acceder a tu cuenta</p>

                    {{-- Mensaje de error del servidor --}}
                    @if(isset($errormsg))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                            <div>{{ $errormsg }}</div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="formLogin" action="{{ url('/login') }}" method="POST" novalidate aria-label="Formulario de inicio de sesión">
                        @csrf

                        {{-- EMAIL con floating label --}}
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email"
                                   class="form-control"
                                   placeholder="nombre@ejemplo.com"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   aria-describedby="email-help">
                            <label for="email">
                                <i class="bi bi-envelope" aria-hidden="true"></i> Email
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        {{-- PASSWORD con floating label + botón ojo --}}
                        <div class="mb-3 position-relative">
                            <div class="form-floating">
                                <input type="password" name="password" id="password"
                                       class="form-control"
                                       placeholder="Contraseña"
                                       required
                                       autocomplete="current-password">
                                <label for="password">
                                    <i class="bi bi-key" aria-hidden="true"></i> Contraseña
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="button"
                                    class="btn-toggle-password icono-input-floating"
                                    data-target="password"
                                    aria-label="Mostrar contraseña"
                                    data-bs-toggle="tooltip"
                                    title="Mostrar/ocultar contraseña">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2" id="btnSubmit">
                            <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Entrar
                        </button>

                        <div class="text-center mt-4">
                            <small class="text-muted">¿No tienes cuenta?</small>
                            <a href="{{ route('formularioRegistro') }}" class="d-block mt-1 enlace-oro">
                                Regístrate ahora <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
{{-- Lógica del formulario de login (validación + listeners). --}}
<script src="{{ asset('assets/js/login.js') }}"></script>
<script src="{{ asset('assets/js/registro.js') }}"></script>
@endsection

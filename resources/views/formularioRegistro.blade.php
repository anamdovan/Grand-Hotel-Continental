@extends('layouts.publico')

@section('titulo', 'Crear cuenta')

@section('contenido')
<section class="py-5 seccion-auth">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="auth-card fade-up">

                    <h2 class="titulo-serif"><i class="bi bi-person-plus" aria-hidden="true"></i> Crear cuenta</h2>
                    <div class="divider-oro"></div>
                    <p class="text-center text-muted mb-4">Únete y disfruta de una experiencia única</p>

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

                    <form id="formRegistro" action="{{ route('registro') }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control"
                                           placeholder="Tu nombre"
                                           value="{{ old('nombre') }}"
                                           required
                                           autocomplete="given-name">
                                    <label for="nombre">
                                        <i class="bi bi-person" aria-hidden="true"></i> Nombre

                                    </label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="apellidos" id="apellidos"
                                           class="form-control"
                                           placeholder="Tus apellidos"
                                           value="{{ old('apellidos') }}"
                                           required
                                           autocomplete="family-name">
                                    <label for="apellidos">
                                        <i class="bi bi-person" aria-hidden="true"></i> Apellidos
                                    </label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mt-3">
                            <input type="email" name="email" id="email"
                                   class="form-control"
                                   placeholder="nombre@ejemplo.com"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email">
                            <label for="email">
                                <i class="bi bi-envelope" aria-hidden="true"></i> Email
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3">
                            <input type="tel" name="telefono" id="telefono"
                                   class="form-control"
                                   placeholder="Teléfono"
                                   value="{{ old('telefono') }}"
                                   autocomplete="tel">
                            <label for="telefono">
                                <i class="bi bi-telephone" aria-hidden="true"></i> Teléfono (opcional)
                            </label>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mt-3 position-relative">
                            <div class="form-floating">
                                <input type="password" name="password" id="password"
                                       class="form-control"
                                       placeholder="Contraseña"
                                       required
                                       autocomplete="new-password">
                                <label for="password">
                                    <i class="bi bi-key" aria-hidden="true"></i> Contraseña
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="button"
                                    class="btn-toggle-password icono-input-floating"
                                    data-target="password"
                                    aria-label="Mostrar contraseña">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>

                        {{-- REPETIR PASSWORD --}}
                        <div class="mt-3 position-relative">
                            <div class="form-floating">
                                <input type="password" name="rePassword" id="rePassword"
                                       class="form-control"
                                       placeholder="Repetir contraseña"
                                       required
                                       autocomplete="new-password">
                                <label for="rePassword">
                                    <i class="bi bi-key-fill" aria-hidden="true"></i> Repetir contraseña
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="button"
                                    class="btn-toggle-password icono-input-floating"
                                    data-target="rePassword"
                                    aria-label="Mostrar contraseña">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="terminos" required>
                            <label class="form-check-label small" for="terminos">
                                Acepto los términos y condiciones
                            </label>
                            <div class="invalid-feedback">Debes aceptar los términos.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4" id="btnSubmit">
                            <i class="bi bi-person-plus" aria-hidden="true"></i> Crear cuenta
                        </button>

                        <div class="text-center mt-4">
                            <small class="text-muted">¿Ya tienes cuenta?</small>
                            <a href="{{ route('login') }}" class="d-block mt-1 enlace-oro">
                                Inicia sesión <i class="bi bi-arrow-right" aria-hidden="true"></i>
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
{{-- Lógica del formulario de registro (validación + listeners). --}}
<script src="{{ asset('assets/js/registro.js') }}"></script>
@endsection


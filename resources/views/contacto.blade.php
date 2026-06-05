@extends('layouts.publico')

@section('titulo', 'Contacto')

@section('contenido')
<section class="py-5 seccion-pt-navbar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <p class="text-uppercase text-muted text-center section-tag">— Contacto —</p>
                <h1 class="titulo-serif text-center mb-3">Escríbenos</h1>
                <p class="text-center text-muted mb-5">
                    ¿Tienes alguna duda? Rellena el formulario y te responderemos lo antes posible.
                </p>

                {{-- Mensaje de éxito --}}
                @if(session('mensaje'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('mensaje') }}</div>
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

                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('contacto.enviar') }}" method="POST" id="formContacto" novalidate>
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="nombre" id="nombre" class="form-control"
                                               placeholder="Nombre" required
                                               value="{{ old('nombre') }}">
                                        <label for="nombre">
                                            <i class="bi bi-person"></i> Nombre *
                                        </label>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="telefono" id="telefono" class="form-control"
                                               placeholder="Teléfono"
                                               value="{{ old('telefono') }}">
                                        <label for="telefono">
                                            <i class="bi bi-telephone"></i> Teléfono (opcional)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mt-3">
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="email" required
                                       value="{{ old('email') }}">
                                <label for="email">
                                    <i class="bi bi-envelope"></i> Email *
                                </label>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="asunto" id="asunto" class="form-control"
                                       placeholder="Asunto" required
                                       value="{{ old('asunto') }}">
                                <label for="asunto">
                                    <i class="bi bi-tag"></i> Asunto *
                                </label>
                            </div>

                            <div class="form-floating mt-3">
                                <textarea name="mensaje" id="mensaje" class="form-control textarea-xl"
                                          placeholder="Mensaje" required>{{ old('mensaje') }}</textarea>
                                <label for="mensaje">
                                    <i class="bi bi-chat-text"></i> Mensaje *
                                </label>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="btnSubmit">
                                    <i class="bi bi-send"></i> Enviar mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


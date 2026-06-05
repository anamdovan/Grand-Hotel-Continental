@extends('layouts.publico')

@section('titulo', 'Dejar opinión')

@section('contenido')
<section class="py-5 seccion-con-navbar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <p class="text-uppercase text-muted section-tag">— Tu experiencia —</p>
                <h1 class="titulo-serif mb-3">Dejar opinión</h1>

                <p class="text-muted">
                    Cuéntanos qué te ha parecido la
                    <strong>{{ $reserva->habitacion->tipo }}</strong>
                    (nº {{ $reserva->habitacion->numero }}).
                </p>

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
                    <div class="card-body p-4">
                        <form action="{{ route('opinar.guardar', $reserva->id) }}" method="POST" id="formOpinion" novalidate>
                            @csrf

                            <label class="form-label">Tu puntuación *</label>
                            <div class="mb-3" id="estrellas">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="puntuacion" id="estrella{{ $i }}" value="{{ $i }}" class="d-none" required>
                                    <label for="estrella{{ $i }}" class="estrella estrella-grande">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>

                            <div class="form-floating mb-3">
                                <textarea name="comentario" id="comentario" class="form-control textarea-opinion"
                                          placeholder="Comentario" required></textarea>
                                <label for="comentario">Tu comentario (mín. 10 caracteres)</label>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('miCuenta') }}" class="btn btn-outline-primary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Publicar opinión
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

@section('js')
{{-- Lógica del formulario de opinión separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/formOpinion.js') }}"></script>
@endsection

@extends('layouts.admin')

@section('titulo', 'Responder mensaje')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mensajes') }}">Mensajes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Responder</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-reply-fill text-oro"></i>
            Responder mensaje
        </h1>
        <p class="text-muted mb-0">Escribe la respuesta y se guardará en el sistema</p>
    </div>
    <a href="{{ route('admin.mensajes') }}" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row g-4">
    {{-- ============ COLUMNA IZQUIERDA: MENSAJE ORIGINAL ============ --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <h4 class="titulo-serif subtitulo-card">
                    <i class="bi bi-envelope-open text-oro"></i>
                    Mensaje original
                </h4>
                <hr>

                <dl class="mb-0">
                    <dt class="small text-muted text-uppercase">De</dt>
                    <dd>
                        <strong>{{ $msg->nombre }}</strong><br>
                        <a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>
                    </dd>

                    @if($msg->telefono)
                        <dt class="small text-muted text-uppercase">Teléfono</dt>
                        <dd>{{ $msg->telefono }}</dd>
                    @endif

                    <dt class="small text-muted text-uppercase">Asunto</dt>
                    <dd>{{ $msg->asunto }}</dd>

                    <dt class="small text-muted text-uppercase">Fecha</dt>
                    <dd>{{ \Carbon\Carbon::parse($msg->created_at)->format('d/m/Y H:i') }}</dd>

                    <dt class="small text-muted text-uppercase">Mensaje</dt>
                    <dd class="p-3 bloque-mensaje">{{ $msg->mensaje }}</dd>
                </dl>
            </div>
        </div>
    </div>


    {{-- ============ COLUMNA DERECHA: FORMULARIO DE RESPUESTA ============ --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <h4 class="titulo-serif subtitulo-card">
                    <i class="bi bi-pencil-square text-oro"></i>
                    Tu respuesta
                </h4>
                <hr>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{-- Si ya hay una respuesta, la mostramos. Si no, mostramos el form. --}}
                @if($msg->respuesta)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>Respondido</strong> el {{ \Carbon\Carbon::parse($msg->fechaRespuesta)->format('d/m/Y H:i') }}
                    </div>
                    <p class="p-3 bloque-respuesta">{{ $msg->respuesta }}</p>
                @else
                    {{-- Aún no se ha respondido: enseñamos el form --}}
                    <form action="{{ route('admin.mensajes.guardar', $msg->id) }}" method="POST" id="formRespuesta" novalidate>
                        @csrf

                        <div class="form-floating">
                            <textarea name="respuesta" id="respuesta" class="form-control textarea-respuesta"
                                      placeholder="Escribe aquí tu respuesta..."
                                      required>{{ old('respuesta') }}</textarea>
                            <label for="respuesta">Tu respuesta (mínimo 10 caracteres)</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.mensajes') }}" class="btn btn-outline-primary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="bi bi-send"></i> Guardar respuesta
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection


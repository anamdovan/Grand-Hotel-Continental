@extends('layouts.publico')

@section('titulo', 'Reservar habitación')

@section('contenido')
<section class="py-5 seccion-pt-navbar">
    <div class="container">

        {{-- Cabecera --}}
        <p class="text-uppercase text-muted text-center section-tag">— Nueva reserva —</p>
        <h1 class="titulo-serif text-center mb-3">Reservar habitación</h1>
        <div class="divider-decoration">
            <i class="bi bi-suit-diamond-fill" aria-hidden="true"></i>
        </div>

        {{-- Errores generales (no asociados a un campo concreto, ej. servicios) --}}
        @if($errors->has('servicios') || $errors->has('servicios.*'))
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->get('servicios') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach($errors->get('servicios.*') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- El precio por noche se pasa al JS como data-attribute --}}
        <form action="{{ route('reservar.guardar', $habitacion->id) }}"
              method="POST" id="formReservarCliente"
              data-precio="{{ $habitacion->precio }}"
              novalidate>
            @csrf

            <div class="row g-4">

                {{-- ============ COLUMNA IZQUIERDA: HABITACIÓN ============ --}}
                <div class="col-lg-5">
                    <div class="card h-100">
                        <img src="{{ asset('assets/img/habitaciones/'.\Illuminate\Support\Str::slug($habitacion->tipo).'.jpg') }}"
                             class="card-img-top img-cardtop"
                             alt="Habitación {{ $habitacion->tipo }}"
                             onerror="this.src='{{ asset('assets/img/DELUXE-MATRIMONIALA-202-grand81344.jpg') }}';">
                        <div class="card-body">
                            <h3 class="card-title">{{ $habitacion->tipo }}</h3>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-door-closed"></i> Habitación nº {{ $habitacion->numero }}
                            </p>
                            <p class="card-text small">{{ $habitacion->descripcion ?? 'Habitación elegante con todas las comodidades.' }}</p>
                            <hr>
                            <p class="mb-0">
                                <strong class="precio-grande">
                                    {{ number_format($habitacion->precio, 2, ',', '.') }} €
                                </strong>
                                <small class="text-muted">/ noche</small>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ============ COLUMNA DERECHA: FECHAS + RESUMEN ============ --}}
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-body p-4">

                            {{-- Cliente (info) --}}
                            <h4 class="titulo-serif subtitulo-card">
                                <i class="bi bi-person-fill text-oro"></i>
                                Reserva a nombre de
                            </h4>
                            <p class="mb-3">
                                <strong>{{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</strong>
                                <br><small class="text-muted">{{ Auth::user()->email }}</small>
                            </p>

                            <hr>

                            {{-- Fechas --}}
                            <h4 class="titulo-serif subtitulo-card">
                                <i class="bi bi-calendar-event text-oro"></i>
                                Selecciona tus fechas
                            </h4>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="fechaEntrada" id="fechaEntrada"
                                               class="form-control @error('fechaEntrada') is-invalid @enderror"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ old('fechaEntrada') }}" required>
                                        <label for="fechaEntrada"><i class="bi bi-calendar-plus"></i> Entrada *</label>
                                        <div class="invalid-feedback">{{ $errors->first('fechaEntrada') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="fechaSalida" id="fechaSalida"
                                               class="form-control @error('fechaSalida') is-invalid @enderror"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ old('fechaSalida') }}" required>
                                        <label for="fechaSalida"><i class="bi bi-calendar-minus"></i> Salida *</label>
                                        <div class="invalid-feedback">{{ $errors->first('fechaSalida') }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Resumen de precio --}}
                            <div class="mt-4 p-3 bloque-resumen">
                                <h5 class="titulo-serif titulo-resumen mb-2">
                                    <i class="bi bi-receipt"></i> Resumen
                                </h5>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Noches:</span>
                                    <span id="resumen-noches">—</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Habitación/noche:</span>
                                    <span>{{ number_format($habitacion->precio, 2, ',', '.') }} €</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Subtotal habitación:</span>
                                    <span id="resumen-subtotal">— €</span>
                                </div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Servicios extras:</span>
                                    <span id="resumen-extras">0,00 €</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <strong>Total estimado:</strong>
                                    <strong id="resumen-total" class="total-resumen">— €</strong>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>{{-- /.row --}}


            {{-- ============ SECCIÓN COMPLETA: SERVICIOS EXTRAS ============ --}}
            @if(isset($servicios) && $servicios->count() > 0)
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <h4 class="titulo-serif subtitulo-tarjeta mb-1">
                            <i class="bi bi-stars text-oro"></i>
                            Servicios extras
                            <small class="text-muted fs-md">(opcional)</small>
                        </h4>
                        <p class="text-muted small mb-3">Personaliza tu estancia añadiendo los servicios que más te apetezcan.</p>

                        <div class="row g-3">
                            @foreach($servicios as $s)
                                <div class="col-md-6 col-lg-4">
                                    {{-- El label entero es clickable (toda la "tarjeta" del servicio) --}}
                                    <label for="serv{{ $s->id }}" class="servicio-card d-block h-100">
                                        <div class="card h-100 border">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <input class="form-check-input servicio-check me-2 mt-0" type="checkbox"
                                                           name="servicios[]" value="{{ $s->id }}"
                                                           id="serv{{ $s->id }}"
                                                           data-precio="{{ $s->precio }}">
                                                    <strong>{{ $s->nombre }}</strong>
                                                </div>
                                                @if($s->descripcion)
                                                    <p class="small text-muted mb-2">{{ Str::limit($s->descripcion, 80) }}</p>
                                                @endif
                                                <div class="text-end">
                                                    <span class="badge badge-oro">
                                                        +{{ number_format($s->precio, 2, ',', '.') }} €
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


            {{-- ============ BOTONES ============ --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('habitaciones.catalogo') }}" class="btn btn-outline-primary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="bi bi-check-lg"></i> Confirmar reserva
                </button>
            </div>

        </form>
    </div>
</section>
@endsection

@section('js')
{{-- Lógica del formulario de reservar separada en un archivo JS aparte. --}}
<script src="{{ asset('assets/js/formReservarCliente.js') }}"></script>
@endsection

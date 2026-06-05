@extends('layouts.admin')

@section('titulo', 'Pagos')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pagos</li>
@endsection

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="titulo-serif titulo-form mb-1">
            <i class="bi bi-cash-coin text-oro" aria-hidden="true"></i>
            Pagos
        </h1>
        <p class="text-muted mb-0">Histórico y registro de pagos</p>
    </div>
    <a href="{{ url('/admin/pagos/crear') }}" class="btn btn-primary"
       data-bs-toggle="tooltip" title="Registrar un nuevo pago">
        <i class="bi bi-plus-circle" aria-hidden="true"></i> Nuevo pago
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" aria-label="Listado de pagos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reserva</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pagos as $p)
                        <tr>
                            <td><small class="text-muted">{{ $p->id }}</small></td>
                            <td>
                                <strong>#{{ $p->idReserva }}</strong>
                                @if($p->reserva)
                                    <br><small class="text-muted">{{ optional($p->reserva->user)->nombre }}</small>
                                @endif
                            </td>
                            <td><strong>{{ number_format($p->monto, 2, ',', '.') }} €</strong></td>
                            <td>
                                @php
                                    $iconoMetodo = [
                                        'tarjeta' => 'credit-card',
                                        'efectivo' => 'cash',
                                        'transferencia' => 'bank',
                                        'paypal' => 'paypal'
                                    ][$p->metodo] ?? 'wallet';
                                @endphp
                                <i class="bi bi-{{ $iconoMetodo }}" aria-hidden="true"></i> {{ ucfirst($p->metodo) }}
                            </td>
                            <td>
                                @switch($p->estado)
                                    @case('pendiente')  <span class="badge bg-warning">Pendiente</span>  @break
                                    @case('completado') <span class="badge bg-success">Completado</span> @break
                                    @case('cancelado')  <span class="badge bg-danger">Cancelado</span>   @break
                                @endswitch
                            </td>
                            <td><small>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y H:i') }}</small></td>
                            <td class="text-center">
                                <a href="{{ url('/admin/pagos/editar/'.$p->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip" title="Editar pago">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </a>
                                <a href="{{ url('/admin/pagos/eliminar/'.$p->id) }}"
                                   class="btn btn-sm btn-outline-primary btn-eliminar"
                                   data-bs-toggle="tooltip" title="Eliminar pago"
                                   onclick="return confirmarEliminacion(event, this.href, '¿Eliminar este pago?');">
                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-cash-stack icono-vacio" aria-hidden="true"></i>
                                <p class="mt-2">No hay pagos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('titulo', 'Estadísticas')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('contenido')
<div class="container">
    <h1 class="text-center mb-4">Estadísticas</h1>

    <div class="row g-4">

        {{-- ============ GRÁFICA 1: Reservas por mes ============ --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Reservas por mes (año {{ date('Y') }})</h5>
                    <div class="chart-contenedor">
                        {{-- Los datos del controlador van al canvas como JSON --}}
                        <canvas id="dashboard"
                                data-datos="{{ json_encode($datos) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ GRÁFICA 2: Habitaciones más reservadas (con JOIN) ============ --}}
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Top 5 habitaciones más reservadas</h5>
                    <div class="chart-contenedor">
                        <canvas id="topHabitaciones"
                                data-datos="{{ json_encode($topHabits) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ GRÁFICA 3: Habitaciones mejor valoradas (JOIN + AVG) ============ --}}
        <div class="col-12 col-lg-6 mx-auto">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Top 5 habitaciones mejor valoradas (puntuación media)</h5>
                    <div class="chart-contenedor">
                        <canvas id="mejorValoradas"
                                data-datos="{{ json_encode($mejorValora) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Chart.js (librería para hacer gráficas) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Lógica de lasgráficas --}}
<script src="{{ asset('assets/js/graficasDashboard.js') }}"></script>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Habitacion;
use App\Models\Opinion;


class DashboardController extends Controller
{
    // Cada consulta vive en su MODELO, así que
    // aquí solo orquesto las llamadas

    public function mostrar()
    {
        return view('dashboard', [
            'datos'       => Reserva::getReservasPorMes(),
            'topHabits'   => Habitacion::getHabitacionesMasReservadas(),
            'mejorValora' => Opinion::getHabitacionesMejorValoradas(),
        ]);
    }
}

<?php

/* 
    - IDs 1-10  → año ANTERIOR, todas COMPLETADAS.   
    - IDs 11-28 → año ACTUAL, repartidas por todos los meses para
                  alimentar la gráfica del dashboard. Mezcla de
                  estados (completadas/confirmadas/pendientes/canceladas).
*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TablaReservasSeeder extends Seeder
{
    public function run(): void
    {
        $a  = Carbon::now()->year;       // año actual
        $aA = $a - 1;                    // año anterior

        DB::table('reservas')->insert([

            [
                'fechaEntrada' => Carbon::create($aA, 12, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA, 12, 18, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 960.00,
                'notas'        => null,
                'idUser'       => 4,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($aA, 12,  1),
                'updated_at'   => Carbon::create($aA, 12,  1),
            ],
            [
                'fechaEntrada' => Carbon::create($aA, 11, 20, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA, 11, 23, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 5,
                'idHabitacion' => 3,
                'created_at'   => Carbon::create($aA, 11,  5),
                'updated_at'   => Carbon::create($aA, 11,  5),
            ],
            [
                'fechaEntrada' => Carbon::create($aA, 10, 10, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA, 10, 14, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 520.00,
                'notas'        => null,
                'idUser'       => 6,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($aA, 10,  1),
                'updated_at'   => Carbon::create($aA, 10,  1),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  9,  5, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  9,  8, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 7,
                'idHabitacion' => 4,
                'created_at'   => Carbon::create($aA,  8, 25),
                'updated_at'   => Carbon::create($aA,  8, 25),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  8, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  8, 20, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 2400.00,
                'notas'        => null,
                'idUser'       => 8,
                'idHabitacion' => 6,
                'created_at'   => Carbon::create($aA,  8,  1),
                'updated_at'   => Carbon::create($aA,  8,  1),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  7, 22, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  7, 26, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 356.00,
                'notas'        => null,
                'idUser'       => 9,
                'idHabitacion' => 1,
                'created_at'   => Carbon::create($aA,  7, 10),
                'updated_at'   => Carbon::create($aA,  7, 10),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  6, 12, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  6, 15, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 10,
                'idHabitacion' => 3,
                'created_at'   => Carbon::create($aA,  6,  1),
                'updated_at'   => Carbon::create($aA,  6,  1),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  5,  8, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  5, 12, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 1280.00,
                'notas'        => null,
                'idUser'       => 11,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($aA,  4, 28),
                'updated_at'   => Carbon::create($aA,  4, 28),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  4, 20, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  4, 23, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 390.00,
                'notas'        => null,
                'idUser'       => 12,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($aA,  4, 10),
                'updated_at'   => Carbon::create($aA,  4, 10),
            ],
            [
                'fechaEntrada' => Carbon::create($aA,  3, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($aA,  3, 18, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 13,
                'idHabitacion' => 4,
                'created_at'   => Carbon::create($aA,  3,  1),
                'updated_at'   => Carbon::create($aA,  3,  1),
            ],

            // -------- IDs 11-28: año ACTUAL, distribuidas por meses --------

            // Enero (pasado) → completada
            [
                'fechaEntrada' => Carbon::create($a,  1, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  1, 18, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 960.00,
                'notas'        => null,
                'idUser'       => 14,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($a,  1,  5),
                'updated_at'   => Carbon::create($a,  1,  5),
            ],
            // Febrero (pasado) → completada
            [
                'fechaEntrada' => Carbon::create($a,  2, 10, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  2, 13, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 390.00,
                'notas'        => 'Cliente vegetariano',
                'idUser'       => 4,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($a,  1, 25),
                'updated_at'   => Carbon::create($a,  1, 25),
            ],
            // Marzo (pasado) → completada
            [
                'fechaEntrada' => Carbon::create($a,  3, 20, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  3, 23, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 5,
                'idHabitacion' => 3,
                'created_at'   => Carbon::create($a,  3,  1),
                'updated_at'   => Carbon::create($a,  3,  1),
            ],
            // Abril (pasado) → completada
            [
                'fechaEntrada' => Carbon::create($a,  4,  5, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  4,  8, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 585.00,
                'notas'        => null,
                'idUser'       => 6,
                'idHabitacion' => 4,
                'created_at'   => Carbon::create($a,  3, 20),
                'updated_at'   => Carbon::create($a,  3, 20),
            ],
            // Mayo (pasado) → completada
            [
                'fechaEntrada' => Carbon::create($a,  5,  1, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  5,  5, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 356.00,
                'notas'        => null,
                'idUser'       => 7,
                'idHabitacion' => 1,
                'created_at'   => Carbon::create($a,  4, 20),
                'updated_at'   => Carbon::create($a,  4, 20),
            ],
            // Mayo (pasado) → completada (segunda del mes)
            [
                'fechaEntrada' => Carbon::create($a,  5, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  5, 19, 12, 0, 0),
                'estado'       => 'completada',
                'total'        => 1280.00,
                'notas'        => null,
                'idUser'       => 8,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($a,  5,  1),
                'updated_at'   => Carbon::create($a,  5,  1),
            ],
            // Junio (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a,  6,  1, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  6,  4, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 390.00,
                'notas'        => null,
                'idUser'       => 9,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($a,  5, 20),
                'updated_at'   => Carbon::create($a,  5, 20),
            ],
            // Junio (futuro) → confirmada (segunda del mes)
            [
                'fechaEntrada' => Carbon::create($a,  6, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  6, 20, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 2400.00,
                'notas'        => 'Pareja en luna de miel',
                'idUser'       => 10,
                'idHabitacion' => 6,
                'created_at'   => Carbon::create($a,  5, 10),
                'updated_at'   => Carbon::create($a,  5, 10),
            ],
            // Julio (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a,  7, 10, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  7, 14, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 780.00,
                'notas'        => null,
                'idUser'       => 11,
                'idHabitacion' => 3,
                'created_at'   => Carbon::create($a,  5, 15),
                'updated_at'   => Carbon::create($a,  5, 15),
            ],
            // Julio (futuro) → pendiente
            [
                'fechaEntrada' => Carbon::create($a,  7, 25, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  7, 30, 12, 0, 0),
                'estado'       => 'pendiente',
                'total'        => 1600.00,
                'notas'        => null,
                'idUser'       => 12,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($a,  5, 22),
                'updated_at'   => Carbon::create($a,  5, 22),
            ],
            // Agosto (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a,  8, 10, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  8, 15, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 975.00,
                'notas'        => null,
                'idUser'       => 13,
                'idHabitacion' => 4,
                'created_at'   => Carbon::create($a,  5, 18),
                'updated_at'   => Carbon::create($a,  5, 18),
            ],
            // Agosto (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a,  8, 20, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  8, 23, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 390.00,
                'notas'        => null,
                'idUser'       => 14,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($a,  5, 19),
                'updated_at'   => Carbon::create($a,  5, 19),
            ],
            // Septiembre (futuro) → pendiente
            [
                'fechaEntrada' => Carbon::create($a,  9,  5, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  9,  8, 12, 0, 0),
                'estado'       => 'pendiente',
                'total'        => 267.00,
                'notas'        => null,
                'idUser'       => 4,
                'idHabitacion' => 1,
                'created_at'   => Carbon::create($a,  5, 21),
                'updated_at'   => Carbon::create($a,  5, 21),
            ],
            // Septiembre (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a,  9, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a,  9, 19, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 780.00,
                'notas'        => null,
                'idUser'       => 5,
                'idHabitacion' => 3,
                'created_at'   => Carbon::create($a,  5, 12),
                'updated_at'   => Carbon::create($a,  5, 12),
            ],
            // Octubre (futuro) → cancelada
            [
                'fechaEntrada' => Carbon::create($a, 10, 12, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a, 10, 15, 12, 0, 0),
                'estado'       => 'cancelada',
                'total'        => 960.00,
                'notas'        => 'Cancelado por cliente',
                'idUser'       => 6,
                'idHabitacion' => 5,
                'created_at'   => Carbon::create($a,  4,  8),
                'updated_at'   => Carbon::create($a,  5,  2),
            ],
            // Noviembre (futuro) → pendiente
            [
                'fechaEntrada' => Carbon::create($a, 11, 20, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a, 11, 23, 12, 0, 0),
                'estado'       => 'pendiente',
                'total'        => 390.00,
                'notas'        => null,
                'idUser'       => 7,
                'idHabitacion' => 2,
                'created_at'   => Carbon::create($a,  5, 14),
                'updated_at'   => Carbon::create($a,  5, 14),
            ],
            // Diciembre (futuro) → confirmada
            [
                'fechaEntrada' => Carbon::create($a, 12, 15, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a, 12, 18, 12, 0, 0),
                'estado'       => 'confirmada',
                'total'        => 1440.00,
                'notas'        => null,
                'idUser'       => 8,
                'idHabitacion' => 6,
                'created_at'   => Carbon::create($a,  5, 16),
                'updated_at'   => Carbon::create($a,  5, 16),
            ],
            // Diciembre (futuro) → pendiente
            [
                'fechaEntrada' => Carbon::create($a, 12, 22, 14, 0, 0),
                'fechaSalida'  => Carbon::create($a, 12, 27, 12, 0, 0),
                'estado'       => 'pendiente',
                'total'        => 975.00,
                'notas'        => 'Reserva navideña',
                'idUser'       => 9,
                'idHabitacion' => 4,
                'created_at'   => Carbon::create($a,  5, 24),
                'updated_at'   => Carbon::create($a,  5, 24),
            ],
        ]);
    }
}

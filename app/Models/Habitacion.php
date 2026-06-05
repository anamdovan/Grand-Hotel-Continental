<?php

/* =====================================================================
 |  Habitacion.php
 |  ---------------------------------------------------------------------
 |  MODELO de HABITACIÓN (tabla 'habitaciones' en la BBDD).
 |
 |  Campos: id, numero, tipo, precio, descripcion, imagenHab, estado.
 |  Estado puede ser: 'disponible', 'ocupada', 'mantenimiento'.
 |
 |  RELACIONES:
 |    - reservas()  →  Una habitación PUEDE tener MUCHAS reservas
 |                     (en diferentes fechas, por distintos clientes).
 | =====================================================================*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Habitacion extends Model
{
    protected $table = 'habitaciones';


    /**
     *  -----------------------------------------------------------------
     *  Devuelve las 5 habitaciones con MÁS reservas hechas.
     *
     *  Uso un JOIN entre las tablas 'habitaciones' y 'reservas':
     */
    public static function getHabitacionesMasReservadas()
    {
        return self::select(
                    'habitaciones.id',
                    'habitaciones.tipo as tipo',
                    'habitaciones.numero as numero',
                    DB::raw('COUNT(reservas.id) AS total_reservas')
                )
                ->join('reservas', 'habitaciones.id', '=', 'reservas.idHabitacion')
                ->groupBy('habitaciones.id', 'habitaciones.tipo', 'habitaciones.numero')
                ->orderBy('total_reservas', 'desc')
                ->limit(5)
                ->get();
    }


    /**
     *  Relación "uno a muchos" (hasMany):
     *  Una habitación PUEDE tener muchas reservas a lo largo del tiempo.
     *  La FK en 'reservas' es 'idHabitacion'.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'idHabitacion');
    }


    /**
     *  Relación "uno a muchos":
     *  Una habitación puede tener muchas opiniones de distintos clientes.
     */
    public function opiniones()
    {
        return $this->hasMany(Opinion::class, 'idHabitacion');
    }


}

<?php

/* =====================================================================
 |  Reserva.php
 |  ---------------------------------------------------------------------
 |  MODELO de RESERVA (tabla 'reservas' en la BBDD).
 |
 |  Campos: id, fechaEntrada, fechaSalida, estado, total, notas,
 |          idUser (FK), idHabitacion (FK), created_at, updated_at.
 |
 |  Estados posibles: 'pendiente', 'confirmada', 'cancelada', 'completada'.
 |
 |  RELACIONES:
 |    - user()       → La reserva pertenece a UN usuario   (cliente que reservó)
 |    - habitacion() → La reserva pertenece a UNA habitación
 |    - pago()       → La reserva tiene UN pago asociado (o ninguno)
 | =====================================================================*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class Reserva extends Model
{
    protected $table = 'reservas';


    /**
     *  Método devuelve un array con el número de reservas
     *  creadas en cada uno de los 12 meses del AÑO ACTUAL.
     *  Lo uso en el DASHBOARD para pintar la gráfica
     */
    public static function getReservasPorMes()
    {
        $datos = [];

        // Año actual
        $anioActual = Carbon::now()->year;

        // Recorremos los 12 meses del año (enero a diciembre)
        for ($mes = 1; $mes <= 12; $mes++) {

            // 1) Construyo una fecha en el día 1 del mes correspondiente
            $fecha = Carbon::create($anioActual, $mes, 1);

            // 2) Primer y último instante de ese mes
            $inicio = $fecha->copy()->startOfMonth();
            $fin    = $fecha->copy()->endOfMonth();

            // 3) cuento cuántas reservas tienen created_at dentro de ese rango
            $total = self::whereBetween('created_at', [$inicio, $fin])->count();

            // 4) Lo guardo en el array con la etiqueta del mes
            $datos[] = [
                'mes'   => $fecha->translatedFormat('F'),  // "Enero", "Febrero"...
                'total' => $total,
            ];
        }

        return $datos;
    }


    /**
     *  Relación "muchos a uno" (belongsTo):
     *  Muchas reservas pueden pertenecer al MISMO usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }


    //Relación "muchos a uno"
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'idHabitacion');
    }

    // Relación "uno a uno"
    public function pago()
    {
        return $this->hasOne(Pago::class, 'idReserva');
    }

    // Relación "uno a uno" 

    public function opinion()
    {
        return $this->hasOne(Opinion::class, 'idReserva');
    }


    // Relación "muchos a muchos" 
    public function servicios()
    {
        return $this->belongsToMany(
            Servicio::class,
            'reserva_servicio',
            'idReserva',
            'idServicio'
        );
    }
}

<?php

/* =====================================================================
 |  Opinion.php
 |  ---------------------------------------------------------------------
 |  MODELO de OPINIÓN (tabla 'opiniones').
 |
 |  Cada opinión pertenece a un USUARIO, a una HABITACIÓN y a una RESERVA.
 |  Tiene una puntuación de 1 a 5 estrellas y un comentario.
 | =====================================================================*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Opinion extends Model
{
    protected $table = 'opiniones';


    // ==================================================================
    //  RELACIONES
    // ==================================================================

    /** Relación con el usuario que dejó la opinión */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    /** Relación con la habitación valorada */
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'idHabitacion');
    }

    /** Relación con la reserva concreta */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'idReserva');
    }


    // ==================================================================
    //  CONSULTAS ESTÁTICAS (para el dashboard)
    // ==================================================================

    /**
     *  Devuelve las habitaciones con MEJOR puntuación media.
     *
     *  Usa un JOIN entre opiniones y habitaciones, y la función SQL AVG()
     *  para calcular la nota media. Limita a habitaciones con al menos
     *  1 opinión y ordena por nota descendente.
     */
    public static function getHabitacionesMejorValoradas()
    {
        return self::select(
                    'habitaciones.id',
                    'habitaciones.tipo as tipo',
                    'habitaciones.numero as numero',
                    DB::raw('ROUND(AVG(opiniones.puntuacion), 2) AS nota_media'),
                    DB::raw('COUNT(opiniones.id) AS total_opiniones')
                )
                ->join('habitaciones', 'opiniones.idHabitacion', '=', 'habitaciones.id')
                ->groupBy('habitaciones.id', 'habitaciones.tipo', 'habitaciones.numero')
                ->orderBy('nota_media', 'desc')
                ->limit(5)
                ->get();
    }


    /**
     *  Devuelve las 6 mejores opiniones (puntuación >= 4) ordenadas por
     *  fecha más reciente
     * Testimonio
     */
    public static function getDestacadas()
    {
        return self::with(['user', 'habitacion'])
                   ->where('puntuacion', '>=', 4)
                   ->orderBy('created_at', 'desc')
                   ->limit(6)
                   ->get();
    }
}

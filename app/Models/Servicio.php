<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Servicio extends Model
{
    protected $table = 'servicios';

    /**
     *  Relación "muchos a muchos" con RESERVAS:
     *  Un servicio puede estar añadido en muchas reservas, y una reserva
     *  puede contratar varios servicios.
     */
    public function reservas()
    {
        return $this->belongsToMany(
            \App\Models\Reserva::class,
            'reserva_servicio',
            'idServicio',
            'idReserva'
        );
    }
}

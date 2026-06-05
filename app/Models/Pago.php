<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    /**
     *  Relación "muchos a uno" (belongsTo):
     *  Cada pago pertenece a UNA reserva.
     *
     *  Uso:  $pago->reserva->total      →  total de la reserva
     *        $pago->reserva->user       →  cliente que reservó
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'idReserva');
    }
}

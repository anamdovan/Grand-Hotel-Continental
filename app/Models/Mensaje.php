<?php

/* =====================================================================
 |  Mensaje.php
 |  ---------------------------------------------------------------------
 |  Modelo de los mensajes del formulario de contacto público.
 |
 |  Cualquier visitante (registrado o no) puede mandar un mensaje:
 |    - Si es visitante anónimo → idUsuarioRemitente queda NULL
 |    - Si es usuario registrado → idUsuarioRemitente guarda su id
 |
 |  Cuando un recepcionista o administrador responde desde el panel:
 |    - idUsuarioRespuesta guarda el id del que respondió
 |    - respuesta y fechaRespuesta guardan el contenido y la fecha
 |
 |  Relaciones (Eloquent):
 |    - remitente()   → BelongsTo User (opcional, puede ser null)
 |    - responsable() → BelongsTo User (opcional, puede ser null)
 | =====================================================================*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Mensaje extends Model
{
    protected $table = 'mensajes';


    /**
     * Usuario registrado que envió el mensaje desde el formulario.
     * Devuelve NULL si lo envió un visitante anónimo.
     * Corresponde a la relación E/R "envía" (USUARIO 0:N — MENSAJE 0:1).
     */
    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUsuarioRemitente');
    }


    /**
     * Usuario del personal (recepcionista o admin) que respondió.
     * Devuelve NULL si el mensaje está pendiente sin responder.
     * Corresponde a la relación E/R "responde" (PERSONAL 0:N — MENSAJE 0:1).
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUsuarioRespuesta');
    }
}

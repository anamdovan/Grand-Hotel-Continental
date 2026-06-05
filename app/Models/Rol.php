<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rol extends Model
{
    // Nombre explícito de la tabla
    protected $table = 'roles';


    
    // Relación "uno a muchos" (hasMany):
    // Un rol PUEDE estar asignado a muchos usuarios.
    
    public function usuarios()
    {
        return $this->hasMany(User::class, 'idRol');
    }
}

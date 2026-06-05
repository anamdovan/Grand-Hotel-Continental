<?php

/* =====================================================================
 |  MIGRACIÓN: crear tabla 'roles'
 |  ---------------------------------------------------------------------
 |  Define la estructura de la tabla 'roles', que almacena los 3
 |  tipos de usuarios del sistema: admin, recepcionista, cliente.
 |
 |  Esta tabla DEBE crearse antes que 'users' porque 'users' tiene una
 |  foreign key (idRol) que apunta aquí.
 | =====================================================================*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     *  up() → Se ejecuta cuando aplicas la migración con `php artisan migrate`.
     *         Aquí definimos la tabla con sus columnas.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            // id() → columna 'id', clave primaria, AUTO_INCREMENT
            $table->id();

            // string('tipoRol', 50) → columna VARCHAR(50)
            // El '50' es la longitud máxima (caracteres).
            $table->string('tipoRol', 50);

            // timestamps() → crea automáticamente DOS columnas:
            //   - created_at  (cuándo se creó la fila)
            //   - updated_at  (cuándo se modificó por última vez)
            $table->timestamps();
        });
    }


    /**
     *  down() → Se ejecuta cuando deshaces la migración (`migrate:rollback`).
     *           Aquí indicamos cómo DESHACER lo que hizo up().
     */
    public function down(): void
    {
        // Borra la tabla 'roles' si existe (no falla si no existe)
        Schema::dropIfExists('roles');
    }
};

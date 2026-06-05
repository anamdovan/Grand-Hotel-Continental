<?php

/* =====================================================================
 |  MIGRACIÓN: crear tabla 'users' (+ password_reset_tokens + sessions)
 |  ---------------------------------------------------------------------
 |  Define la tabla principal de USUARIOS del hotel.
 |
 |  Esta migración crea 3 tablas a la vez:
 |    - users                  → usuarios del sistema
 |    - password_reset_tokens  → tokens para recuperar contraseña
 |    - sessions               → sesiones activas (SESSION_DRIVER=database)
 | =====================================================================*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        // ==============================================================
        //  Tabla 'users'
        // ==============================================================
        Schema::create('users', function (Blueprint $table) {

            $table->id();   // PK auto-incremental

            // email único → no se puede repetir en la tabla.
            // Si alguien intenta registrarse con un email ya existente,
            // la BBDD lanza error.
            $table->string('email')->unique();

            // Cuándo el usuario verificó su email (sistema de Laravel
            // que en este proyecto no usamos pero está disponible).
            // nullable() → puede ser NULL.
            $table->timestamp('email_verified_at')->nullable();

            // Contraseña hasheada (NUNCA texto plano).
            $table->string('password');

            // rememberToken() → columna de 100 chars para la cookie
            // "recordarme" del login. La gestiona Laravel sola.
            $table->rememberToken();

            // created_at + updated_at
            $table->timestamps();

            // ----- CAMPOS PROPIOS DEL PROYECTO -----
            // nullable porque al loguearse con Auth::attempt() no son
            // estrictamente obligatorios.
            $table->string('nombre')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->string('imagenUser')->nullable();

            // ----- FOREIGN KEY a 'roles' -----
            // BigInteger sin signo (como el id de roles, que es BIGINT UNSIGNED)
            $table->unsignedBigInteger('idRol');
            // Restricción de integridad: idRol debe existir en roles.id
            // onDelete('cascade') → si se borra el rol, también se borran sus users
            // onUpdate('cascade') → si cambia el id del rol, se actualiza aquí también
            $table->foreign('idRol')
                  ->references('id')->on('roles')
                  ->onDelete('cascade')->onUpdate('cascade')
                  ->after('id');
        });


        // ==============================================================
        //  Tabla 'password_reset_tokens'
        //  Tokens para recuperar contraseña (Laravel built-in).
        // ==============================================================
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();      // PK por email
            $table->string('token');                  // el token aleatorio
            $table->timestamp('created_at')->nullable();
        });


        // ==============================================================
        //  Tabla 'sessions'
        //  Almacena las sesiones activas (porque .env usa SESSION_DRIVER=database).
        //  Cada navegador que abre la web crea una fila aquí.
        // ==============================================================
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();                            // ID único de sesión
            $table->foreignId('user_id')->nullable()->index();          // FK a users (null si no logueado)
            $table->string('ip_address', 45)->nullable();               // IP del navegador
            $table->text('user_agent')->nullable();                     // navegador / SO
            $table->longText('payload');                                // datos serializados
            $table->integer('last_activity')->index();                  // última vez que se usó
        });
    }


    public function down(): void
    {
        // Borrar las 3 tablas creadas
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

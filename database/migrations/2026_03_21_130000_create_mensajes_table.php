<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                       // del visitante
            $table->string('email');                        // para responderle
            $table->string('telefono')->nullable();         // opcional
            $table->string('asunto');
            $table->text('mensaje');
            $table->text('respuesta')->nullable();          // respuesta del personal
            $table->dateTime('fechaRespuesta')->nullable(); // fecha de la respuesta

            // NULLABLE porque el formulario está abierto a visitantes
            // sin cuenta (en ese caso solo se guarda nombre y email arriba).
            $table->unsignedBigInteger('idUsuarioRemitente')->nullable();
            $table->foreign('idUsuarioRemitente')
                  ->references('id')->on('users')
                  ->onDelete('set null')->onUpdate('cascade');

            // NULLABLE porque mientras el mensaje está pendiente no hay
            // respuesta asignada. Solo se rellena cuando un usuario con
            // rol 'recepcionista' o 'admin' responde desde el panel.
            $table->unsignedBigInteger('idUsuarioRespuesta')->nullable();
            $table->foreign('idUsuarioRespuesta')
                  ->references('id')->on('users')
                  ->onDelete('set null')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};

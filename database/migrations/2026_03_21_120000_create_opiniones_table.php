<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opiniones', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('puntuacion');
            $table->text('comentario');
            
            $table->foreignId('idUser')
                  ->constrained('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('idHabitacion')
                  ->constrained('habitaciones')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('idReserva')
                  ->constrained('reservas')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opiniones');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva_servicio', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idReserva')
                  ->constrained('reservas')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('idServicio')
                  ->constrained('servicios')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_servicio');
    }
};

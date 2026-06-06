<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {

            $table->id();
            $table->decimal('monto', 10, 2);
            $table->string('metodo', 50);
            $table->enum('estado', ['pendiente', 'completado', 'cancelado'])
                  ->default('pendiente');
            // Fecha del pago. useCurrent() = por defecto el momento de insertar
            $table->dateTime('fechaPago')->useCurrent();
            $table->timestamps();

            $table->unsignedBigInteger('idReserva');
            $table->foreign('idReserva')
                  ->references('id')->on('reservas')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {

            $table->id(); 
            $table->dateTime('fechaEntrada');
            $table->dateTime('fechaSalida');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'completada'])
                  ->default('pendiente');
            // nullable porque podría rellenarse después del precálculo.
            $table->decimal('total', 10, 2)->nullable();
            $table->text('notas')->nullable();

            $table->foreignId('idUser')
                  ->constrained('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('idHabitacion')
                  ->constrained('habitaciones')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

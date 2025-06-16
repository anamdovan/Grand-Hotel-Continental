<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fechaEntrada');
            $table->dateTime('fechaSalida');
            $table->integer('nrHabitaciones');
            $table->timestamps();

            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idHabitacion');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->after('id');
            $table->foreign('idHabitacion')->references('id')->on('habitaciones')->onDelete('cascade')->onUpdate('cascade')->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

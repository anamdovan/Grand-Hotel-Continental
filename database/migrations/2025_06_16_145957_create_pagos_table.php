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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fechaPago');
            $table->string('metodoPago');
            $table->timestamps();

            $table->unsignedBigInteger('idReserva');
            $table->foreign('idReserva')->references('id')->on('reservas')->onDelete('cascade')->onUpdate('cascade')->after('id');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

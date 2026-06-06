<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {

            $table->id();

            $table->dateTime('fechaEmision');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            $table->unsignedBigInteger('idPago');
            $table->foreign('idPago')
                  ->references('id')->on('pagos')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};

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

            // Cuándo se emitió la factura
            $table->dateTime('fechaEmision');

            // Total facturado (8 dígitos, 2 decimales → hasta 999.999,99 €)
            $table->decimal('total', 8, 2);

            $table->timestamps();

            // FK a pagos: cada factura está vinculada a UN pago.
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

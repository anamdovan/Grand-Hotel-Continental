<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habitaciones', function (Blueprint $table) {

            $table->id();   // PK auto-incremental

            // unique() impide tener dos habitaciones con el mismo número.
            $table->string('numero', 10)->unique();
            $table->string('tipo', 50);
            $table->decimal('precio', 8, 2);
            $table->text('descripcion')->nullable();
            $table->string('imagenHab')->nullable();
            $table->enum('estado', ['disponible', 'ocupada', 'mantenimiento'])
                  ->default('disponible');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};

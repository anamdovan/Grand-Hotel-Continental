<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');                    // VARCHAR(255) por defecto
            $table->text('descripcion')->nullable();     // texto largo opcional
            $table->decimal('precio', 8, 2);             // precio del servicio
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};

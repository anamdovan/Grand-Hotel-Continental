<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('tipoRol', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Borra la tabla 'roles' si existe (no falla si no existe)
        Schema::dropIfExists('roles');
    }
};

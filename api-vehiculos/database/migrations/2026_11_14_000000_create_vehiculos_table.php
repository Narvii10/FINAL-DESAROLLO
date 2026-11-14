<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla vehiculos en MySQL.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();                          // identificador autoincremental
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->unsignedSmallInteger('anio');  // año del vehículo
            $table->string('color', 30);
            $table->timestamps();                  // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla (php artisan migrate:rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};

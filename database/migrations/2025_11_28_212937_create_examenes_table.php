<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examenes', function (Blueprint $table) {
            $table->id();

            // nombre del examen que escribirá el médico
            $table->string('nombre')->unique();

            // categoría opcional (laboratorio, imagen, cardiología, orina, etc)
            $table->string('categoria')->nullable();

            // descripción opcional
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examenes');
    }
};

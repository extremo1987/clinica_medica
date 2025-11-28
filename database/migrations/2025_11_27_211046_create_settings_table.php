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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Información de la clínica
            $table->string('nombre_clinica')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();

            // Logo
            $table->string('logo')->nullable();

            // Información del doctor
            $table->string('doctor')->nullable();
            $table->string('registro_medico')->nullable();
            $table->string('especialidad')->nullable();

            // Preferencias
            $table->string('tipo_pago_default')->default('Efectivo');
            $table->boolean('mostrar_logo_recetas')->default(true);
            $table->boolean('mostrar_direccion_recetas')->default(true);

            // Pie de página PDF
            $table->string('footer_pdf')->nullable();

            // Para extensiones futuras
            $table->json('extras')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

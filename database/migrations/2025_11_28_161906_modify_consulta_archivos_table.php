<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consulta_archivos', function (Blueprint $table) {

            // Eliminar columnas antiguas si existen
            if (Schema::hasColumn('consulta_archivos', 'tipo')) {
                $table->dropColumn('tipo');
            }
            if (Schema::hasColumn('consulta_archivos', 'archivo')) {
                $table->dropColumn('archivo');
            }

            // Nuevas columnas correctas
            $table->string('nombre_archivo')->nullable();
            $table->string('ruta_archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('consulta_archivos', function (Blueprint $table) {
            // nada necesario
        });
    }
};

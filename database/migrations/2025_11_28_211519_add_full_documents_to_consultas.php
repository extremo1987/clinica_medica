<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('consultas', function (Blueprint $table) {

        // Receta médica
        $table->longText('receta')->nullable();

        // Incapacidad — texto adicional
        $table->longText('incapacidad_detalle')->nullable();

        // Remisión — texto adicional
        $table->longText('remision_detalle')->nullable();
    });
}

public function down()
{
    Schema::table('consultas', function (Blueprint $table) {
        $table->dropColumn(['receta', 'incapacidad_detalle', 'remision_detalle']);
    });
}

};

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

        // INCAPACIDAD
        $table->integer('dias_incapacidad')->nullable();
        $table->date('incapacidad_inicio')->nullable();
        $table->date('incapacidad_fin')->nullable();
        $table->text('motivo_incapacidad')->nullable();

        // REMISIÓN
        $table->string('hospital_destino')->nullable();
        $table->text('motivo_remision')->nullable();
        $table->string('diagnostico_remision')->nullable();
    });
}

public function down()
{
    Schema::table('consultas', function (Blueprint $table) {
        $table->dropColumn([
            'dias_incapacidad',
            'incapacidad_inicio',
            'incapacidad_fin',
            'motivo_incapacidad',
            'hospital_destino',
            'motivo_remision',
            'diagnostico_remision'
        ]);
    });
}

   
};

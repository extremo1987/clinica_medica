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
    
            $table->string('peso')->nullable()->change();
            $table->string('estatura')->nullable()->change();
            $table->string('presion_arterial')->nullable()->change();
            $table->string('frecuencia_cardiaca')->nullable()->change();
            $table->string('frecuencia_respiratoria')->nullable()->change();
            $table->string('temperatura')->nullable()->change();
            $table->string('saturacion_o2')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
    
            $table->decimal('peso', 6, 2)->nullable()->change();
            $table->decimal('estatura', 6, 2)->nullable()->change();
            $table->string('presion_arterial', 20)->nullable()->change();
            $table->integer('frecuencia_cardiaca')->nullable()->change();
            $table->integer('frecuencia_respiratoria')->nullable()->change();
            $table->decimal('temperatura', 4, 1)->nullable()->change();
            $table->integer('saturacion_o2')->nullable()->change();
        });
    }
    
};

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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
    
            // Expediente autogenerado (P-00001)
            $table->string('expediente')->unique();
    
            $table->string('nombre');
            $table->string('identidad')->nullable();
            $table->date('fecha_nacimiento')->nullable();
    
            $table->enum('sexo', ['M', 'F'])->nullable();
    
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
    
            $table->timestamps(); // creado / actualizado
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
    
};

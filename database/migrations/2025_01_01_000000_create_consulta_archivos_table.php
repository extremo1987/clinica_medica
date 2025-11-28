<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consulta_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained()->onDelete('cascade');

            $table->enum('tipo', ['receta', 'incapacidad', 'remision']);
            $table->string('archivo'); // ruta PDF

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consulta_archivos');
    }
};

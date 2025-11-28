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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            // relación con paciente
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');

            // datos generales de la consulta
            $table->dateTime('fecha_consulta')->nullable(); // si quieres por defecto ahora, lo pones en controlador
            $table->text('motivo')->nullable();

            // signos vitales
            $table->decimal('peso', 6, 2)->nullable();       // kg
            $table->decimal('estatura', 6, 2)->nullable();   // cm o m según prefieras
            $table->string('presion_arterial', 20)->nullable(); // "120/80"
            $table->integer('frecuencia_cardiaca')->nullable(); // lpm
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable(); // °C
            $table->integer('saturacion_o2')->nullable(); // %

            // diagnostico / cie10
            $table->text('diagnostico')->nullable();
            $table->string('cie10', 50)->nullable();

            // tratamiento
            $table->text('tratamiento')->nullable();

            // exámenes solicitados (guardado como json para flexibilidad)
            $table->json('examenes')->nullable();

            // pago
            $table->decimal('monto', 10, 2)->default(0);
            $table->string('tipo_pago', 50)->nullable(); // Efectivo, Tarjeta, Transferencia, etc.
            $table->boolean('pagado')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};

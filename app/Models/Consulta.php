<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'fecha_consulta',
        'motivo',
    
        // signos vitales
        'peso',
        'estatura',
        'presion_arterial',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'temperatura',
        'saturacion_o2',
    
        // diagnóstico
        'diagnostico',
        'cie10',
    
        // tratamiento
        'tratamiento',
    
        // nueva receta
        'receta',
    
        // exámenes JSON
        'examenes',
    
        // incapacidad
        'dias_incapacidad',
        'incapacidad_inicio',
        'incapacidad_fin',
        'incapacidad_detalle', // NUEVO
    
        // remisión
        'hospital_destino',
        'motivo_remision',
        'remision_detalle', // NUEVO
    
        // pago
        'monto',
        'tipo_pago',
        'pagado',
    ];
    

    protected $casts = [
        'examenes'            => 'array',
        'fecha_consulta'      => 'datetime',
        'pagado'              => 'boolean',
        'incapacidad_inicio'  => 'date',
        'incapacidad_fin'     => 'date',
    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Archivos adjuntos
    public function archivos()
    {
        return $this->hasMany(ConsultaArchivo::class);
    }
}

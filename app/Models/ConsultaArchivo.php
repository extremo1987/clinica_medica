<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaArchivo extends Model
{
    protected $table = 'consulta_archivos';

    protected $fillable = [
        'consulta_id',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_archivo',
        'observacion'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    // URL del archivo listo para usar en vistas
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->ruta_archivo);
    }
}

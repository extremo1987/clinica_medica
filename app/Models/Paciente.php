<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'expediente',
        'nombre',
        'identidad',
        'fecha_nacimiento',
        'edad',
        'sexo',
        'telefono',
        'email',
        'foto',
        'direccion'
    ];

    // Generador automático de expediente P-00001
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paciente) {
            $ultimo = Paciente::orderBy('id', 'desc')->first();
            $numero = $ultimo ? $ultimo->id + 1 : 1;
            $paciente->expediente = 'P-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
        });
    }

    // Relación con consultas (IMPORTANTE para show.blade.php)
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}

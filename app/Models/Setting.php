<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nombre_clinica','telefono','whatsapp','email','direccion',
        'doctor','registro_medico','especialidad','logo',
        'mostrar_logo_recetas','mostrar_direccion_recetas','footer_pdf'
    ];

    protected $casts = [
        'mostrar_logo_recetas' => 'integer',
        'mostrar_direccion_recetas' => 'integer'
    ];
}

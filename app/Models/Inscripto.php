<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_apellido',
        'dni',
        'fecha_nacimiento',
        'genero',
        'email',
        'telefono',
        'direccion',
        'localidad_ciudad',
        'cv',
        'fotografia'
    ];
}

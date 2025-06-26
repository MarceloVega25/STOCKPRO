<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veedor extends Model
{
    use HasFactory, SoftDeletes; // Agrega esta línea

    protected $table = 'veedores';

    protected $fillable = [
        'nombre_apellido',
        'dni',
        'fecha_nacimiento',
        'genero',
        'email',
        'telefono',
        'institucion',
        'cargo',
        'cv',
        'fotografia'
    ];
}

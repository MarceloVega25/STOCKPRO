<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reparto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'docentes';

    protected $fillable = [
        'nombre_apellido',
        'dni',
        'fecha_nacimiento',
        'genero',
        'email',
        'telefono',
        'institucion',
        'tipo',
        'cv',
        'fotografia'
    ];
}

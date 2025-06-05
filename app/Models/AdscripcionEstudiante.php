<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdscripcionEstudiante extends Model
{
    use HasFactory;

    protected $table = 'adscripcion_estudiante';

    protected $fillable = [
        'adscripcion_id',
        'estudiante_id',
        'tipo', // titular o suplente
    ];

    public function adscripcion()
    {
        return $this->belongsTo(Adscripcion::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}

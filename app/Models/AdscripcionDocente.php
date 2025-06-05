<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdscripcionDocente extends Model
{
    use HasFactory;

    protected $table = 'adscripcion_docente';

    protected $fillable = [
        'adscripcion_id',
        'docente_id',
        'tipo', // titular o suplente
    ];

    public function adscripcion()
    {
        return $this->belongsTo(Adscripcion::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
}

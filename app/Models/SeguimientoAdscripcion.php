<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoAdscripcion extends Model
{
   protected $table = 'seguimientos_adscripciones';

    protected $fillable = [
        'adscripcion_id',
        'accion',
        'detalle',
        'usuario',
        'fecha',
    ];

    protected $dates = ['fecha'];

    public function adscripcion()
    {
        return $this->belongsTo(Adscripcion::class);
    }
}

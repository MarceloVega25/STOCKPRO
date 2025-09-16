<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'tabla_afectada',
        'operacion',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'usuario_id',
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoCategoria extends Model
{
    protected $table = 'seguimientos_categorias';

    protected $fillable = [
        'categoria_id',
        'accion',
        'detalle',
        'usuario',
        'fecha',
    ];

    protected $dates = ['fecha'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

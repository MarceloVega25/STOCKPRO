<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoCompra extends Model
{
    protected $table = 'seguimientos_compras';

    protected $fillable = [
        'compra_id',
        'accion',
        'detalle',
        'usuario',
        'fecha',
    ];

    protected $dates = ['fecha'];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
}

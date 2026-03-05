<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCompra extends Model
{
    use HasFactory;

    protected $table = 'estados_compras';

    protected $fillable = [
        'compra_id',
        'estado',
        'comentario',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
}

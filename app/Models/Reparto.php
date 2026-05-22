<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparto extends Model
{
    use HasFactory;

    protected $table = 'repartos';

    protected $fillable = [
        'compra_id',
        'repartidor_id',
        'vehiculo_id',
        'fecha_reparto',
        'estado',
        'direccion_entrega',
        'observaciones'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function repartidor()
    {
        return $this->belongsTo(Repartidor::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}

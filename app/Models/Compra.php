<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compras';

    protected $fillable = [
        'numero',
        'anio',
        'fecha',
        'comprobante',
        'proveedor_id',
        'observaciones',
        'total',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function getCodigoAttribute()
    {
        return $this->numero . '/' . $this->anio;
    }

    public function items()
    {
        return $this->hasMany(CompraItem::class, 'compra_id');
    }

    public function repartos()
    {
        return $this->hasMany(Reparto::class, 'compra_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCompra::class, 'compra_id');
    }
}

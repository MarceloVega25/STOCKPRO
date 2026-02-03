<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'razon_social',
        'cuit',
        'email',
        'telefono',
        'direccion',
        'localidad_ciudad',
        'condicion_iva',
    ];
}

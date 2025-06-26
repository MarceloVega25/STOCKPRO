<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jerarquia extends Model
{
    use HasFactory,SoftDeletes; // Agrega esta línea

    protected $fillable = [
        'nombre',
        'siglas',
    ];
}

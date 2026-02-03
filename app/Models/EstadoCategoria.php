<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCategoria extends Model
{
    use HasFactory;

    protected $table = 'estado_categorias';

    protected $fillable = [
        'categoria_id',
        'estado',
        'comentario',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

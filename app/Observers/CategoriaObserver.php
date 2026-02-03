<?php

namespace App\Observers;

use App\Models\Categoria;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class CategoriaObserver
{
    public function created(Categoria $categoria)
    {
        Auditoria::create([
            'tabla_afectada' => 'categorias',
            'operacion' => 'INSERT',
            'registro_id' => $categoria->id,
            'datos_nuevos' => json_encode($categoria),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Categoria $categoria)
    {
        Auditoria::create([
            'tabla_afectada' => 'categorias',
            'operacion' => 'UPDATE',
            'registro_id' => $categoria->id,
            'datos_anteriores' => json_encode($categoria->getOriginal()),
            'datos_nuevos' => json_encode($categoria->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Categoria $categoria)
    {
        Auditoria::create([
            'tabla_afectada' => 'categorias',
            'operacion' => 'DELETE',
            'registro_id' => $categoria->id,
            'datos_anteriores' => json_encode($categoria),
            'usuario_id' => Auth::id(),
        ]);
    }
}

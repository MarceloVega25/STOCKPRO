<?php

namespace App\Observers;

use App\Models\Compra;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class CompraObserver
{
    public function created(Compra $compra)
    {
        Auditoria::create([
            'tabla_afectada' => 'compras',
            'operacion' => 'INSERT',
            'registro_id' => $compra->id,
            'datos_nuevos' => json_encode($compra),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Compra $compra)
    {
        Auditoria::create([
            'tabla_afectada' => 'compras',
            'operacion' => 'UPDATE',
            'registro_id' => $compra->id,
            'datos_anteriores' => json_encode($compra->getOriginal()),
            'datos_nuevos' => json_encode($compra->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Compra $compra)
    {
        Auditoria::create([
            'tabla_afectada' => 'compras',
            'operacion' => 'DELETE',
            'registro_id' => $compra->id,
            'datos_anteriores' => json_encode($compra),
            'usuario_id' => Auth::id(),
        ]);
    }
}

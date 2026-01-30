<?php

namespace App\Observers;

use App\Models\Producto;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class ProductoObserver
{
    public function created(Producto $producto)
    {
        Auditoria::create([
            'tabla_afectada' => 'productos',
            'operacion' => 'INSERT',
            'registro_id' => $producto->id,
            'datos_nuevos' => json_encode($producto),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Producto $producto)
    {
        Auditoria::create([
            'tabla_afectada' => 'productos',
            'operacion' => 'UPDATE',
            'registro_id' => $producto->id,
            'datos_anteriores' => json_encode($producto->getOriginal()),
            'datos_nuevos' => json_encode($producto->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Producto $producto)
    {
        Auditoria::create([
            'tabla_afectada' => 'productos',
            'operacion' => 'DELETE',
            'registro_id' => $producto->id,
            'datos_anteriores' => json_encode($producto),
            'usuario_id' => Auth::id(),
        ]);
    }
}

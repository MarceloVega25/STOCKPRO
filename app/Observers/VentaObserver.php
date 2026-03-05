<?php

namespace App\Observers;

use App\Models\Venta;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class VentaObserver
{
    public function created(Venta $venta)
    {
        Auditoria::create([
            'tabla_afectada' => 'ventas',
            'operacion' => 'INSERT',
            'registro_id' => $venta->id,
            'datos_nuevos' => json_encode($venta),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Venta $venta)
    {
        Auditoria::create([
            'tabla_afectada' => 'ventas',
            'operacion' => 'UPDATE',
            'registro_id' => $venta->id,
            'datos_anteriores' => json_encode($venta->getOriginal()),
            'datos_nuevos' => json_encode($venta->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Venta $venta)
    {
        Auditoria::create([
            'tabla_afectada' => 'ventas',
            'operacion' => 'DELETE',
            'registro_id' => $venta->id,
            'datos_anteriores' => json_encode($venta),
            'usuario_id' => Auth::id(),
        ]);
    }
}

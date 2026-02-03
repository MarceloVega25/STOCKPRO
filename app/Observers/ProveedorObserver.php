<?php

namespace App\Observers;

use App\Models\Proveedor;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class ProveedorObserver
{
    public function created(Proveedor $proveedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'proveedores',
            'operacion' => 'INSERT',
            'registro_id' => $proveedor->id,
            'datos_nuevos' => json_encode($proveedor),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Proveedor $proveedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'proveedores',
            'operacion' => 'UPDATE',
            'registro_id' => $proveedor->id,
            'datos_anteriores' => json_encode($proveedor->getOriginal()),
            'datos_nuevos' => json_encode($proveedor->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Proveedor $proveedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'proveedores',
            'operacion' => 'DELETE',
            'registro_id' => $proveedor->id,
            'datos_anteriores' => json_encode($proveedor),
            'usuario_id' => Auth::id(),
        ]);
    }
}

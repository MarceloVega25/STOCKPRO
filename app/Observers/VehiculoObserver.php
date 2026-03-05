<?php

namespace App\Observers;

use App\Models\Vehiculo;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class VehiculoObserver
{
    public function created(Vehiculo $vehiculo)
    {
        Auditoria::create([
            'tabla_afectada' => 'vehiculos',
            'operacion' => 'INSERT',
            'registro_id' => $vehiculo->id,
            'datos_nuevos' => json_encode($vehiculo),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Vehiculo $vehiculo)
    {
        Auditoria::create([
            'tabla_afectada' => 'vehiculos',
            'operacion' => 'UPDATE',
            'registro_id' => $vehiculo->id,
            'datos_anteriores' => json_encode($vehiculo->getOriginal()),
            'datos_nuevos' => json_encode($vehiculo->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Vehiculo $vehiculo)
    {
        Auditoria::create([
            'tabla_afectada' => 'vehiculos',
            'operacion' => 'DELETE',
            'registro_id' => $vehiculo->id,
            'datos_anteriores' => json_encode($vehiculo),
            'usuario_id' => Auth::id(),
        ]);
    }
}

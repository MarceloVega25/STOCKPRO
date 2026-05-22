<?php

namespace App\Observers;

use App\Models\Repartidor;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class RepartidorObserver
{
    public function created(Repartidor $repartidor)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartidores',
            'operacion' => 'INSERT',
            'registro_id' => $repartidor->id,
            'datos_nuevos' => json_encode($repartidor),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Repartidor $repartidor)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartidores',
            'operacion' => 'UPDATE',
            'registro_id' => $repartidor->id,
            'datos_anteriores' => json_encode($repartidor->getOriginal()),
            'datos_nuevos' => json_encode($repartidor->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Repartidor $repartidor)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartidores',
            'operacion' => 'DELETE',
            'registro_id' => $repartidor->id,
            'datos_anteriores' => json_encode($repartidor),
            'usuario_id' => Auth::id(),
        ]);
    }
}

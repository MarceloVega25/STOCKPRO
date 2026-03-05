<?php

namespace App\Observers;

use App\Models\Reparto;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class RepartoObserver
{
    public function created(Reparto $reparto)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartos',
            'operacion' => 'INSERT',
            'registro_id' => $reparto->id,
            'datos_nuevos' => json_encode($reparto),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Reparto $reparto)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartos',
            'operacion' => 'UPDATE',
            'registro_id' => $reparto->id,
            'datos_anteriores' => json_encode($reparto->getOriginal()),
            'datos_nuevos' => json_encode($reparto->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Reparto $reparto)
    {
        Auditoria::create([
            'tabla_afectada' => 'repartos',
            'operacion' => 'DELETE',
            'registro_id' => $reparto->id,
            'datos_anteriores' => json_encode($reparto),
            'usuario_id' => Auth::id(),
        ]);
    }
}

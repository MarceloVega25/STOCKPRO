<?php

namespace App\Observers;

use App\Models\Asignatura;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AsignaturaObserver
{
    public function created(Asignatura $asignatura)
    {
        Auditoria::create([
            'tabla_afectada' => 'asignaturas',
            'operacion' => 'INSERT',
            'registro_id' => $asignatura->id,
            'datos_nuevos' => json_encode($asignatura),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Asignatura $asignatura)
    {
        Auditoria::create([
            'tabla_afectada' => 'asignaturas',
            'operacion' => 'UPDATE',
            'registro_id' => $asignatura->id,
            'datos_anteriores' => json_encode($asignatura->getOriginal()),
            'datos_nuevos' => json_encode($asignatura->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Asignatura $asignatura)
    {
        Auditoria::create([
            'tabla_afectada' => 'asignaturas',
            'operacion' => 'DELETE',
            'registro_id' => $asignatura->id,
            'datos_anteriores' => json_encode($asignatura),
            'usuario_id' => Auth::id(),
        ]);
    }
}

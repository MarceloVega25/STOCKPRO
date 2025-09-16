<?php

namespace App\Observers;

use App\Models\Docente;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class DocenteObserver
{
    public function created(Docente $docente)
    {
        Auditoria::create([
            'tabla_afectada' => 'docentes',
            'operacion' => 'INSERT',
            'registro_id' => $docente->id,
            'datos_nuevos' => json_encode($docente),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Docente $docente)
    {
        Auditoria::create([
            'tabla_afectada' => 'docentes',
            'operacion' => 'UPDATE',
            'registro_id' => $docente->id,
            'datos_anteriores' => json_encode($docente->getOriginal()),
            'datos_nuevos' => json_encode($docente->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Docente $docente)
    {
        Auditoria::create([
            'tabla_afectada' => 'docentes',
            'operacion' => 'DELETE',
            'registro_id' => $docente->id,
            'datos_anteriores' => json_encode($docente),
            'usuario_id' => Auth::id(),
        ]);
    }
}

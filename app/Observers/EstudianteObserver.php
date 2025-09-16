<?php

namespace App\Observers;

use App\Models\Estudiante;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class EstudianteObserver
{
    public function created(Estudiante $estudiante)
    {
        Auditoria::create([
            'tabla_afectada' => 'estudiantes',
            'operacion' => 'INSERT',
            'registro_id' => $estudiante->id,
            'datos_nuevos' => json_encode($estudiante),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Estudiante $estudiante)
    {
        Auditoria::create([
            'tabla_afectada' => 'estudiantes',
            'operacion' => 'UPDATE',
            'registro_id' => $estudiante->id,
            'datos_anteriores' => json_encode($estudiante->getOriginal()),
            'datos_nuevos' => json_encode($estudiante->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Estudiante $estudiante)
    {
        Auditoria::create([
            'tabla_afectada' => 'estudiantes',
            'operacion' => 'DELETE',
            'registro_id' => $estudiante->id,
            'datos_anteriores' => json_encode($estudiante),
            'usuario_id' => Auth::id(),
        ]);
    }
}

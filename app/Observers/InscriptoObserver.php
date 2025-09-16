<?php

namespace App\Observers;

use App\Models\Inscripto;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class InscriptoObserver
{
    public function created(Inscripto $inscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'inscriptos',
            'operacion' => 'INSERT',
            'registro_id' => $inscripto->id,
            'datos_nuevos' => json_encode($inscripto),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Inscripto $inscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'inscriptos',
            'operacion' => 'UPDATE',
            'registro_id' => $inscripto->id,
            'datos_anteriores' => json_encode($inscripto->getOriginal()),
            'datos_nuevos' => json_encode($inscripto->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Inscripto $inscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'inscriptos',
            'operacion' => 'DELETE',
            'registro_id' => $inscripto->id,
            'datos_anteriores' => json_encode($inscripto),
            'usuario_id' => Auth::id(),
        ]);
    }
}

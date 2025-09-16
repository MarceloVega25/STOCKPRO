<?php

namespace App\Observers;

use App\Models\Carrera;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class CarreraObserver
{
    public function created(Carrera $carrera)
    {
        Auditoria::create([
            'tabla_afectada' => 'carreras',
            'operacion' => 'INSERT',
            'registro_id' => $carrera->id,
            'datos_nuevos' => json_encode($carrera),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Carrera $carrera)
    {
        Auditoria::create([
            'tabla_afectada' => 'carreras',
            'operacion' => 'UPDATE',
            'registro_id' => $carrera->id,
            'datos_anteriores' => json_encode($carrera->getOriginal()),
            'datos_nuevos' => json_encode($carrera->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Carrera $carrera)
    {
        Auditoria::create([
            'tabla_afectada' => 'carreras',
            'operacion' => 'DELETE',
            'registro_id' => $carrera->id,
            'datos_anteriores' => json_encode($carrera),
            'usuario_id' => Auth::id(),
        ]);
    }
}

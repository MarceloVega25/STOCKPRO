<?php

namespace App\Observers;

use App\Models\Adscripcion;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AdscripcionObserver
{
    public function created(Adscripcion $adscripcion)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscripciones',
            'operacion' => 'INSERT',
            'registro_id' => $adscripcion->id,
            'datos_nuevos' => json_encode($adscripcion),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Adscripcion $adscripcion)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscripciones',
            'operacion' => 'UPDATE',
            'registro_id' => $adscripcion->id,
            'datos_anteriores' => json_encode($adscripcion->getOriginal()),
            'datos_nuevos' => json_encode($adscripcion->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Adscripcion $adscripcion)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscripciones',
            'operacion' => 'DELETE',
            'registro_id' => $adscripcion->id,
            'datos_anteriores' => json_encode($adscripcion),
            'usuario_id' => Auth::id(),
        ]);
    }
}

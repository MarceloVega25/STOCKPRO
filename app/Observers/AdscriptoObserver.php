<?php

namespace App\Observers;

use App\Models\Adscripto;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AdscriptoObserver
{
    public function created(Adscripto $adscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscriptos',
            'operacion' => 'INSERT',
            'registro_id' => $adscripto->id,
            'datos_nuevos' => json_encode($adscripto),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Adscripto $adscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscriptos',
            'operacion' => 'UPDATE',
            'registro_id' => $adscripto->id,
            'datos_anteriores' => json_encode($adscripto->getOriginal()),
            'datos_nuevos' => json_encode($adscripto->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Adscripto $adscripto)
    {
        Auditoria::create([
            'tabla_afectada' => 'adscriptos',
            'operacion' => 'DELETE',
            'registro_id' => $adscripto->id,
            'datos_anteriores' => json_encode($adscripto),
            'usuario_id' => Auth::id(),
        ]);
    }
}

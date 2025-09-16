<?php

namespace App\Observers;

use App\Models\Jerarquia;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class JerarquiaObserver
{
    public function created(Jerarquia $jerarquia)
    {
        Auditoria::create([
            'tabla_afectada' => 'jerarquias',
            'operacion' => 'INSERT',
            'registro_id' => $jerarquia->id,
            'datos_nuevos' => json_encode($jerarquia),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Jerarquia $jerarquia)
    {
        Auditoria::create([
            'tabla_afectada' => 'jerarquias',
            'operacion' => 'UPDATE',
            'registro_id' => $jerarquia->id,
            'datos_anteriores' => json_encode($jerarquia->getOriginal()),
            'datos_nuevos' => json_encode($jerarquia->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Jerarquia $jerarquia)
    {
        Auditoria::create([
            'tabla_afectada' => 'jerarquias',
            'operacion' => 'DELETE',
            'registro_id' => $jerarquia->id,
            'datos_anteriores' => json_encode($jerarquia),
            'usuario_id' => Auth::id(),
        ]);
    }
}

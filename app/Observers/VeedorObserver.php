<?php

namespace App\Observers;

use App\Models\Veedor;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class VeedorObserver
{
    public function created(Veedor $veedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'veedores',
            'operacion' => 'INSERT',
            'registro_id' => $veedor->id,
            'datos_nuevos' => json_encode($veedor),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Veedor $veedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'veedores',
            'operacion' => 'UPDATE',
            'registro_id' => $veedor->id,
            'datos_anteriores' => json_encode($veedor->getOriginal()),
            'datos_nuevos' => json_encode($veedor->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Veedor $veedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'veedores',
            'operacion' => 'DELETE',
            'registro_id' => $veedor->id,
            'datos_anteriores' => json_encode($veedor),
            'usuario_id' => Auth::id(),
        ]);
    }
}

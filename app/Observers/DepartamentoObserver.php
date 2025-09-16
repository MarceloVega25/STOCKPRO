<?php

namespace App\Observers;

use App\Models\Departamento;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class DepartamentoObserver
{
    public function created(Departamento $departamento)
    {
        Auditoria::create([
            'tabla_afectada' => 'departamentos',
            'operacion' => 'INSERT',
            'registro_id' => $departamento->id,
            'datos_nuevos' => json_encode($departamento),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Departamento $departamento)
    {
        Auditoria::create([
            'tabla_afectada' => 'departamentos',
            'operacion' => 'UPDATE',
            'registro_id' => $departamento->id,
            'datos_anteriores' => json_encode($departamento->getOriginal()),
            'datos_nuevos' => json_encode($departamento->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Departamento $departamento)
    {
        Auditoria::create([
            'tabla_afectada' => 'departamentos',
            'operacion' => 'DELETE',
            'registro_id' => $departamento->id,
            'datos_anteriores' => json_encode($departamento),
            'usuario_id' => Auth::id(),
        ]);
    }
}

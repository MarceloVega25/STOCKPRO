<?php

namespace App\Observers;

use App\Models\Concurso;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class ConcursoObserver
{
    public function created(Concurso $concurso)
    {
        Auditoria::create([
            'tabla_afectada' => 'concursos',
            'operacion' => 'INSERT',
            'registro_id' => $concurso->id,
            'datos_nuevos' => json_encode($concurso),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Concurso $concurso)
    {
        Auditoria::create([
            'tabla_afectada' => 'concursos',
            'operacion' => 'UPDATE',
            'registro_id' => $concurso->id,
            'datos_anteriores' => json_encode($concurso->getOriginal()),
            'datos_nuevos' => json_encode($concurso->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Concurso $concurso)
    {
        Auditoria::create([
            'tabla_afectada' => 'concursos',
            'operacion' => 'DELETE',
            'registro_id' => $concurso->id,
            'datos_anteriores' => json_encode($concurso),
            'usuario_id' => Auth::id(),
        ]);
    }
}

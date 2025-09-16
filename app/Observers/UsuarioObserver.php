<?php

namespace App\Observers;

use App\Models\Usuario;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class UsuarioObserver
{
    public function created(Usuario $usuario)
    {
        Auditoria::create([
            'tabla_afectada' => 'usuarios',
            'operacion' => 'INSERT',
            'registro_id' => $usuario->id,
            'datos_nuevos' => json_encode($usuario),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Usuario $usuario)
    {
        Auditoria::create([
            'tabla_afectada' => 'usuarios',
            'operacion' => 'UPDATE',
            'registro_id' => $usuario->id,
            'datos_anteriores' => json_encode($usuario->getOriginal()),
            'datos_nuevos' => json_encode($usuario->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Usuario $usuario)
    {
        Auditoria::create([
            'tabla_afectada' => 'usuarios',
            'operacion' => 'DELETE',
            'registro_id' => $usuario->id,
            'datos_anteriores' => json_encode($usuario),
            'usuario_id' => Auth::id(),
        ]);
    }
}

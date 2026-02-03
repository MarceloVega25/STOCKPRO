<?php

namespace App\Observers;

use App\Models\Cliente;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class ClienteObserver
{
    public function created(Cliente $cliente)
    {
        Auditoria::create([
            'tabla_afectada' => 'clientes',
            'operacion' => 'INSERT',
            'registro_id' => $cliente->id,
            'datos_nuevos' => json_encode($cliente),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Cliente $cliente)
    {
        Auditoria::create([
            'tabla_afectada' => 'clientes',
            'operacion' => 'UPDATE',
            'registro_id' => $cliente->id,
            'datos_anteriores' => json_encode($cliente->getOriginal()),
            'datos_nuevos' => json_encode($cliente->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Cliente $cliente)
    {
        Auditoria::create([
            'tabla_afectada' => 'clientes',
            'operacion' => 'DELETE',
            'registro_id' => $cliente->id,
            'datos_anteriores' => json_encode($cliente),
            'usuario_id' => Auth::id(),
        ]);
    }
}

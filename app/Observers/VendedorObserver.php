<?php

namespace App\Observers;

use App\Models\Vendedor;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class VendedorObserver
{
    public function created(Vendedor $vendedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'vendedores',
            'operacion' => 'INSERT',
            'registro_id' => $vendedor->id,
            'datos_nuevos' => json_encode($vendedor),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function updated(Vendedor $vendedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'vendedores',
            'operacion' => 'UPDATE',
            'registro_id' => $vendedor->id,
            'datos_anteriores' => json_encode($vendedor->getOriginal()),
            'datos_nuevos' => json_encode($vendedor->getChanges()),
            'usuario_id' => Auth::id(),
        ]);
    }

    public function deleted(Vendedor $vendedor)
    {
        Auditoria::create([
            'tabla_afectada' => 'vendedores',
            'operacion' => 'DELETE',
            'registro_id' => $vendedor->id,
            'datos_anteriores' => json_encode($vendedor),
            'usuario_id' => Auth::id(),
        ]);
    }
}

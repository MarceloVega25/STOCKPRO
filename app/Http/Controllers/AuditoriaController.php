<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        // ⚠ Validación: si se intenta filtrar sin ambas fechas completas, mostrar advertencia
        if (
            ($request->filled('tabla') || $request->filled('usuario_id') || $request->filled('desde') || $request->filled('hasta')) &&
            (!($request->filled('desde') && $request->filled('hasta')))
        ) {
            return redirect()->route('auditorias.index')
                ->withInput()
                ->with('mensaje_error', 'Para aplicar cualquier filtro debe completar ambos campos de fecha: Desde y Hasta.');
        }

        // ✅ Si todo está correcto, construir la consulta con los filtros
        $query = Auditoria::with('usuario')
            ->when($request->filled('tabla'), fn($q) => $q->where('tabla_afectada', $request->tabla))
            ->when($request->filled('usuario_id'), fn($q) => $q->where('usuario_id', $request->usuario_id))
            ->when($request->filled('desde') && $request->filled('hasta'), function ($q) use ($request) {
                $q->whereBetween('fecha', [$request->desde, $request->hasta]);
            })
            ->orderBy('fecha', 'desc');

        $auditorias = $query->paginate(20);

        // Datos para filtros
        $usuarios = \App\Models\Usuario::orderBy('nombre_apellido')->get();
        $tablas = Auditoria::select('tabla_afectada')->distinct()->pluck('tabla_afectada');

        return view('auditorias.index', compact('auditorias', 'usuarios', 'tablas'));
    }

    public function show($id)
    {
        $auditoria = Auditoria::with('usuario')->findOrFail($id);
        return view('auditorias.show', compact('auditoria'));
    }
}

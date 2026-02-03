<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Compra;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Proveedor;
use App\Models\Reparto;
use App\Models\Vehiculo;
use App\Models\Vendedor;
use App\Models\SeguimientoAdscripcion;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with([
            'cliente',
            'carreras',
            'asignaturas',
            'departamentos',
            'designado',
            'estados'
        ])->orderBy('id', 'desc')->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create', [
            'clientes' => Cliente::all(),
            'asignaturas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'proveedores' => Proveedor::all(),
            'docentes' => Reparto::all(),
            'estudiantes' => Vehiculo::all(),
            'veedores' => Vendedor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_adscripcion' => 'required',
            'modalidad_adscripcion' => 'required',
            'designado_id' => 'nullable|exists:proveedores,id',
        ]);

        $compra = Compra::create($request->only([
            'numero',
            'anio',
            'cliente_id',
            'tipo_adscripcion',
            'modalidad_adscripcion',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'fecha_adscripcion',
            'expediente',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));

        $compra->asignaturas()->sync($request->input('asignaturas', []));
        $compra->departamentos()->sync($request->input('departamentos', []));
        $compra->carreras()->sync($request->input('carreras', []));
        $compra->veedores()->sync($request->input('veedores', []));
        $compra->proveedores()->sync($request->input('proveedores', []));

        if ($request->has('docentes_titulares')) {
            foreach ($request->docentes_titulares as $id) {
                $compra->docentes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('docentes_suplentes')) {
            foreach ($request->docentes_suplentes as $id) {
                $compra->docentes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        if ($request->has('estudiantes_titulares')) {
            foreach ($request->estudiantes_titulares as $id) {
                $compra->estudiantes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('estudiantes_suplentes')) {
            foreach ($request->estudiantes_suplentes as $id) {
                $compra->estudiantes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        $detalle = "Compra creada: N° {$compra->numero}/{$compra->anio}, Cliente: " . optional($compra->cliente)->razon_social .
            ", Tipo: {$compra->tipo_adscripcion}, Modalidad: {$compra->modalidad_adscripcion}";

        SeguimientoAdscripcion::create([
            'adscripcion_id' => $compra->id,
            'accion' => 'Compra creada',
            'detalle' => Str::limit($detalle, 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);

        return redirect()->route('compras.index')->with('mensaje', 'Compra creada correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load([
            'cliente',
            'asignaturas',
            'departamentos',
            'carreras',
            'proveedores',
            'veedores',
            'docentesTitulares',
            'docentesSuplentes',
            'estudiantesTitulares',
            'estudiantesSuplentes',
            'estados',
            'designado',
            'seguimientos'
        ]);

        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $compra->load([
            'cliente',
            'asignaturas',
            'departamentos',
            'carreras',
            'docentesTitulares',
            'docentesSuplentes',
            'estudiantesTitulares',
            'estudiantesSuplentes',
            'veedores',
            'proveedores',
        ]);

        return view('compras.edit', [
            'compra' => $compra,
            'clientes' => Cliente::all(),
            'asignaturas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'docentes' => Reparto::all(),
            'estudiantes' => Vehiculo::all(),
            'veedores' => Vendedor::all(),
            'proveedores' => Proveedor::all(),
        ]);
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_adscripcion' => 'required',
            'modalidad_adscripcion' => 'required',
            'designado_id' => 'nullable|exists:proveedores,id',
        ]);

        $original = clone $compra;

        $compra->update($request->only([
            'numero',
            'anio',
            'fecha_adscripcion',
            'expediente',
            'cliente_id',
            'tipo_adscripcion',
            'modalidad_adscripcion',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));

        $compra->asignaturas()->sync($request->input('asignaturas', []));
        $compra->departamentos()->sync($request->input('departamentos', []));
        $compra->carreras()->sync($request->input('carreras', []));
        $compra->veedores()->sync($request->input('veedores', []));
        $compra->proveedores()->sync($request->input('proveedores', []));

        $compra->docentes()->detach();
        foreach ($request->input('docentes_titulares', []) as $id) {
            $compra->docentes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('docentes_suplentes', []) as $id) {
            $compra->docentes()->attach($id, ['tipo' => 'suplente']);
        }

        $compra->estudiantes()->detach();
        foreach ($request->input('estudiantes_titulares', []) as $id) {
            $compra->estudiantes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('estudiantes_suplentes', []) as $id) {
            $compra->estudiantes()->attach($id, ['tipo' => 'suplente']);
        }

        $detalle = "Compra actualizada: N° {$compra->numero}/{$compra->anio}";

        SeguimientoAdscripcion::create([
            'adscripcion_id' => $compra->id,
            'accion' => 'Compra actualizada',
            'detalle' => Str::limit($detalle, 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);

        return redirect()->route('compras.index')->with('mensaje', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();

        return redirect()->route('compras.index')->with('mensaje', 'Compra eliminada correctamente.');
    }

    public function seguimientos($id)
    {
        $compra = Compra::with(['seguimientos' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('compras.seguimientos', compact('compra'));
    }
}

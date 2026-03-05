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
use App\Models\SeguimientoCompra;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with([
            'cliente',
            'carreras',
            'ventas',
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
            'ventas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'proveedores' => Proveedor::all(),
            'repartos' => Reparto::all(),
            'vehiculos' => Vehiculo::all(),
            'vendedores' => Vendedor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_compra' => 'required',
            'modalidad_compra' => 'required',
            'designado_id' => 'nullable|exists:proveedores,id',
        ]);

        $compra = Compra::create($request->only([
            'numero',
            'anio',
            'cliente_id',
            'tipo_compra',
            'modalidad_compra',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'fecha_compra',
            'expediente',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));

        $compra->ventas()->sync($request->input('ventas', []));
        $compra->departamentos()->sync($request->input('departamentos', []));
        $compra->carreras()->sync($request->input('carreras', []));
        $compra->vendedores()->sync($request->input('vendedores', []));
        $compra->proveedores()->sync($request->input('proveedores', []));

        $repartosTitulares = $request->input('repartos_titulares', []);
        foreach ($repartosTitulares as $id) {
            $compra->repartos()->attach($id, ['tipo' => 'titular']);
        }

        $repartosSuplentes = $request->input('repartos_suplentes', []);
        foreach ($repartosSuplentes as $id) {
            $compra->repartos()->attach($id, ['tipo' => 'suplente']);
        }

        $vehiculosTitulares = $request->input('vehiculos_titulares', []);
        foreach ($vehiculosTitulares as $id) {
            $compra->vehiculos()->attach($id, ['tipo' => 'titular']);
        }

        $vehiculosSuplentes = $request->input('vehiculos_suplentes', []);
        foreach ($vehiculosSuplentes as $id) {
            $compra->vehiculos()->attach($id, ['tipo' => 'suplente']);
        }

        $detalle = "Compra creada: N° {$compra->numero}/{$compra->anio}, Cliente: " . optional($compra->cliente)->razon_social .
            ", Tipo: {$compra->tipo_compra}, Modalidad: {$compra->modalidad_compra}";

        SeguimientoCompra::create([
            'compra_id' => $compra->id,
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
            'ventas',
            'departamentos',
            'carreras',
            'proveedores',
            'vendedores',
            'repartosTitulares',
            'repartosSuplentes',
            'vehiculosTitulares',
            'vehiculosSuplentes',
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
            'ventas',
            'departamentos',
            'carreras',
            'repartosTitulares',
            'repartosSuplentes',
            'vehiculosTitulares',
            'vehiculosSuplentes',
            'vendedores',
            'proveedores',
        ]);

        return view('compras.edit', [
            'compra' => $compra,
            'clientes' => Cliente::all(),
            'ventas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'repartos' => Reparto::all(),
            'vehiculos' => Vehiculo::all(),
            'vendedores' => Vendedor::all(),
            'proveedores' => Proveedor::all(),
        ]);
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_compra' => 'required',
            'modalidad_compra' => 'required',
            'designado_id' => 'nullable|exists:proveedores,id',
        ]);

        $original = clone $compra;

        $compra->update($request->only([
            'numero',
            'anio',
            'fecha_compra',
            'expediente',
            'cliente_id',
            'tipo_compra',
            'modalidad_compra',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));

        $compra->ventas()->sync($request->input('ventas', []));
        $compra->departamentos()->sync($request->input('departamentos', []));
        $compra->carreras()->sync($request->input('carreras', []));
        $compra->vendedores()->sync($request->input('vendedores', []));
        $compra->proveedores()->sync($request->input('proveedores', []));

        $compra->repartos()->detach();
        foreach ($request->input('repartos_titulares', []) as $id) {
            $compra->repartos()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('repartos_suplentes', []) as $id) {
            $compra->repartos()->attach($id, ['tipo' => 'suplente']);
        }

        $compra->vehiculos()->detach();
        foreach ($request->input('vehiculos_titulares', []) as $id) {
            $compra->vehiculos()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('vehiculos_suplentes', []) as $id) {
            $compra->vehiculos()->attach($id, ['tipo' => 'suplente']);
        }

        $detalle = "Compra actualizada: N° {$compra->numero}/{$compra->anio}";

        SeguimientoCompra::create([
            'compra_id' => $compra->id,
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

<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Repartidor;
use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class RepartoController extends Controller
{
    public function index()
    {
        $repartos = Reparto::with(['compra', 'repartidor', 'vehiculo'])->orderByDesc('id')->get();
        return view('repartos.index', compact('repartos'));
    }

    public function create()
    {
        return view('repartos.create', [
            'compras' => Compra::orderByDesc('id')->get(),
            'repartidores' => Repartidor::orderBy('nombre_apellido')->get(),
            'vehiculos' => Vehiculo::orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'compra_id' => 'required|exists:compras,id',
            'repartidor_id' => 'required|exists:repartidores,id',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'fecha_reparto' => 'required|date',
            'estado' => 'required|string|max:50',
            'direccion_entrega' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Reparto::create($request->only([
            'compra_id',
            'repartidor_id',
            'vehiculo_id',
            'fecha_reparto',
            'estado',
            'direccion_entrega',
            'observaciones',
        ]));

        return redirect()->route('repartos.index')->with('mensaje', 'Se registró el Reparto correctamente');
    }

    public function show($id)
    {
        $reparto = Reparto::with(['compra', 'repartidor', 'vehiculo'])->findOrFail($id);
        return view('repartos.show', compact('reparto'));
    }

    public function edit($id)
    {
        $reparto = Reparto::findOrFail($id);
        return view('repartos.edit', [
            'reparto' => $reparto,
            'compras' => Compra::orderByDesc('id')->get(),
            'repartidores' => Repartidor::orderBy('nombre_apellido')->get(),
            'vehiculos' => Vehiculo::orderByDesc('id')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'compra_id' => 'required|exists:compras,id',
            'repartidor_id' => 'required|exists:repartidores,id',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'fecha_reparto' => 'required|date',
            'estado' => 'required|string|max:50',
            'direccion_entrega' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $reparto = Reparto::findOrFail($id);

        $reparto->update($request->only([
            'compra_id',
            'repartidor_id',
            'vehiculo_id',
            'fecha_reparto',
            'estado',
            'direccion_entrega',
            'observaciones',
        ]));

        return redirect()->route('repartos.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $reparto = Reparto::findOrFail($id);
        $reparto->delete();

        return redirect()->route('repartos.index')->with('mensaje', 'Se eliminó el Reparto correctamente');
    }
}

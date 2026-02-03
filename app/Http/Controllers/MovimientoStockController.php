<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovimientoStockController extends Controller
{
    public function index()
    {
        $movimientos_stock = Carrera::all()->sortByDesc('id');
        return view('movimientos_stock.index', ['movimientos_stock' => $movimientos_stock]);
    }

    public function create()
    {
        return view('movimientos_stock.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:carreras,nombre',
            'siglas' => 'required|unique:carreras,siglas',
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'La sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $carrera = new Carrera();
        $carrera->nombre = $request->nombre;
        $carrera->siglas = $request->siglas;
        $carrera->save();

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Se Registró el Movimiento de Stock correctamente');
    }

    public function show($id)
    {
        $movimiento_stock = Carrera::findOrFail($id);
        return view('movimientos_stock.show', ['movimiento_stock' => $movimiento_stock]);
    }

    public function edit($id)
    {
        $movimiento_stock = Carrera::findOrFail($id);
        return view('movimientos_stock.edit', ['movimiento_stock' => $movimiento_stock]);
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);

        $request->validate([
            'nombre' => 'required|unique:carreras,nombre,' . $carrera->id,
            'siglas' => 'required|unique:carreras,siglas,' . $carrera->id,
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'Esa Sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $carrera->nombre = $request->nombre;
        $carrera->siglas = $request->siglas;
        $carrera->save();

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Se eliminó el Movimiento de Stock correctamente');
    }
}

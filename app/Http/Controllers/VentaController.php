<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all()->sortByDesc('id');
        return view('ventas.index', ['ventas' => $ventas]);
    }

    public function create()
    {
        return view('ventas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:asignaturas,nombre',
            'siglas' => 'required|unique:asignaturas,siglas',
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'La sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $venta = new Venta();
        $venta->nombre = $request->nombre;
        $venta->siglas = $request->siglas;
        $venta->save();

        return redirect()->route('ventas.index')->with('mensaje', 'Se registró la Venta correctamente');
    }

    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        return view('ventas.show', ['venta' => $venta]);
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        return view('ventas.edit', ['venta' => $venta]);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        $request->validate([
            'nombre' => 'required|unique:asignaturas,nombre,' . $venta->id,
            'siglas' => 'required|unique:asignaturas,siglas,' . $venta->id,
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'Esa Sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $venta->nombre = $request->nombre;
        $venta->siglas = $request->siglas;
        $venta->save();

        return redirect()->route('ventas.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('ventas.index')->with('mensaje', 'Se eliminó la Venta correctamente');
    }
}

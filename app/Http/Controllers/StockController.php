<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stock = Departamento::all()->sortByDesc('id');
        return view('stock.index', ['stock' => $stock]);
    }

    public function create()
    {
        return view('stock.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:departamentos,nombre',
            'siglas' => 'required|unique:departamentos,siglas',
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'La sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $departamento = new Departamento();
        $departamento->nombre = $request->nombre;
        $departamento->siglas = $request->siglas;
        $departamento->save();

        return redirect()->route('stock.index')->with('mensaje', 'Se Registró el Stock Correctamente');
    }

    public function show($id)
    {
        $stock = Departamento::findOrFail($id);
        return view('stock.show', ['stock' => $stock]);
    }

    public function edit($id)
    {
        $stock = Departamento::findOrFail($id);
        return view('stock.edit', ['stock' => $stock]);
    }

    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $request->validate([
            'nombre' => 'required|unique:departamentos,nombre,' . $departamento->id,
            'siglas' => 'required|unique:departamentos,siglas,' . $departamento->id,
        ], [
            'nombre.unique' => 'El Nombre ya está registrado.',
            'siglas.unique' => 'Esa Sigla ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
            'siglas.required' => 'El campo siglas es obligatorio.',
        ]);

        $departamento->nombre = $request->nombre;
        $departamento->siglas = $request->siglas;
        $departamento->save();

        return redirect()->route('stock.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('stock.index')->with('mensaje', 'Se eliminó el Stock correctamente');
    }
}

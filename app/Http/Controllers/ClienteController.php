<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all()->sortByDesc('id');
        return view('clientes.index', ['clientes' => $clientes]);
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required',
            'cuit' => 'required|unique:clientes,cuit',
            'email' => 'nullable|email',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'localidad_ciudad' => 'nullable',
            'condicion_iva' => 'nullable',
        ], [
            'razon_social.required' => 'La razón social es obligatoria.',
            'cuit.required' => 'El CUIT es obligatorio.',
            'cuit.unique' => 'El CUIT ya está registrado.',
        ]);

        $cliente = new Cliente();
        $cliente->razon_social = $request->razon_social;
        $cliente->cuit = $request->cuit;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->localidad_ciudad = $request->localidad_ciudad;
        $cliente->condicion_iva = $request->condicion_iva;
        $cliente->save();

        return redirect()->route('clientes.index')->with('mensaje', 'Se registró el Cliente correctamente');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', ['cliente' => $cliente]);
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', ['cliente' => $cliente]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'razon_social' => 'required',
            'cuit' => 'required|unique:clientes,cuit,' . $id,
            'email' => 'nullable|email',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'localidad_ciudad' => 'nullable',
            'condicion_iva' => 'nullable',
        ], [
            'razon_social.required' => 'La razón social es obligatoria.',
            'cuit.required' => 'El CUIT es obligatorio.',
            'cuit.unique' => 'El CUIT ya está registrado.',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->razon_social = $request->razon_social;
        $cliente->cuit = $request->cuit;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->localidad_ciudad = $request->localidad_ciudad;
        $cliente->condicion_iva = $request->condicion_iva;
        $cliente->save();

        return redirect()->route('clientes.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('mensaje', 'Se eliminó el Cliente correctamente');
    }
}

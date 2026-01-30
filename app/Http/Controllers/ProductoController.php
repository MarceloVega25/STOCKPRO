<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all()->sortByDesc('id');
        return view('productos.index', ['productos' => $productos]);
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'nullable|integer',
            'descripcion' => 'nullable',
        ]);

        Producto::create($request->only(['nombre', 'descripcion', 'precio', 'stock', 'categoria_id']));

        return redirect()->route('productos.index')->with('mensaje', 'Producto creado correctamente');
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', ['producto' => $producto]);
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', ['producto' => $producto]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'nullable|integer',
            'descripcion' => 'nullable',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only(['nombre', 'descripcion', 'precio', 'stock', 'categoria_id']));

        return redirect()->route('productos.index')->with('mensaje', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('mensaje', 'Producto eliminado correctamente');
    }

    public function mostrarBusqueda()
{
    return view('productos.buscar');
}

public function buscarDni(Request $request)
{
    $request->validate([
        'codigo' => ['required'],
    ], [
        'codigo.required' => 'El código es obligatorio.',
    ]);
    

    $producto = Producto::where('id', $request->codigo)->first();

    if ($producto) {
        // Mensaje y redirección con JavaScript desde la vista
        return redirect()->route('productos.buscar')->with([
            'mensaje' => 'existe',
            'producto_id' => $producto->id
        ]);
    } else {
        return redirect()->route('productos.buscar')->with([
            'mensaje' => 'nuevo',
            'codigo' => $request->codigo
        ]);
    }
}


}

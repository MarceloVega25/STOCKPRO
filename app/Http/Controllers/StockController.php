<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $productos = Producto::orderByDesc('id')->get();
        return view('stock.index', ['productos' => $productos]);
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('stock.show', ['producto' => $producto]);
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('stock.edit', ['producto' => $producto]);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'stock_minimo' => 'nullable|integer|min:0',
        ]);

        $producto->stock_minimo = $request->input('stock_minimo');
        $producto->save();

        return redirect()->route('stock.index')->with('mensaje', 'Stock mínimo actualizado correctamente');
    }
}

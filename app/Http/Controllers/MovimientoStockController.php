<?php

namespace App\Http\Controllers;

use App\Models\MovimientoStock;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoStockController extends Controller
{
    public function index()
    {
        $movimientos_stock = MovimientoStock::with(['producto', 'usuario'])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        return view('movimientos_stock.index', ['movimientos_stock' => $movimientos_stock]);
    }

    public function create()
    {
        return view('movimientos_stock.create', [
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'nullable|date',
            'motivo' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $producto = Producto::lockForUpdate()->findOrFail($request->producto_id);

            $movimiento = new MovimientoStock();
            $movimiento->producto_id = $producto->id;
            $movimiento->tipo = $request->tipo;
            $movimiento->cantidad = (int) $request->cantidad;
            $movimiento->fecha = $request->fecha ?? now();
            $movimiento->motivo = $request->motivo;
            $movimiento->usuario_id = Auth::id();
            $movimiento->save();

            $delta = 0;
            if ($movimiento->tipo === 'entrada') {
                $delta = $movimiento->cantidad;
            } elseif ($movimiento->tipo === 'salida') {
                $delta = -$movimiento->cantidad;
            } elseif ($movimiento->tipo === 'ajuste') {
                $delta = $movimiento->cantidad;
            }

            $nuevoStock = ((int) $producto->stock) + $delta;
            if ($nuevoStock < 0) {
                throw new \RuntimeException('El movimiento deja el stock en negativo.');
            }
            $producto->stock = $nuevoStock;
            $producto->save();
        });

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Movimiento de stock registrado correctamente');
    }

    public function show($id)
    {
        $movimiento_stock = MovimientoStock::with(['producto', 'usuario'])->findOrFail($id);
        return view('movimientos_stock.show', ['movimiento_stock' => $movimiento_stock]);
    }

    public function edit($id)
    {
        $movimiento_stock = MovimientoStock::findOrFail($id);
        return view('movimientos_stock.edit', [
            'movimiento_stock' => $movimiento_stock,
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'nullable|date',
            'motivo' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $id) {
            $movimiento = MovimientoStock::lockForUpdate()->findOrFail($id);

            $productoAnterior = Producto::lockForUpdate()->findOrFail($movimiento->producto_id);

            $deltaAnterior = 0;
            if ($movimiento->tipo === 'entrada') {
                $deltaAnterior = $movimiento->cantidad;
            } elseif ($movimiento->tipo === 'salida') {
                $deltaAnterior = -$movimiento->cantidad;
            } elseif ($movimiento->tipo === 'ajuste') {
                $deltaAnterior = $movimiento->cantidad;
            }
            $productoAnterior->stock = ((int) $productoAnterior->stock) - $deltaAnterior;
            if ($productoAnterior->stock < 0) {
                throw new \RuntimeException('No se puede editar: revertir el movimiento deja stock negativo.');
            }
            $productoAnterior->save();

            $movimiento->producto_id = $request->producto_id;
            $movimiento->tipo = $request->tipo;
            $movimiento->cantidad = (int) $request->cantidad;
            $movimiento->fecha = $request->fecha ?? $movimiento->fecha;
            $movimiento->motivo = $request->motivo;
            $movimiento->usuario_id = Auth::id();
            $movimiento->save();

            $productoNuevo = Producto::lockForUpdate()->findOrFail($movimiento->producto_id);

            $deltaNuevo = 0;
            if ($movimiento->tipo === 'entrada') {
                $deltaNuevo = $movimiento->cantidad;
            } elseif ($movimiento->tipo === 'salida') {
                $deltaNuevo = -$movimiento->cantidad;
            } elseif ($movimiento->tipo === 'ajuste') {
                $deltaNuevo = $movimiento->cantidad;
            }
            $nuevoStock = ((int) $productoNuevo->stock) + $deltaNuevo;
            if ($nuevoStock < 0) {
                throw new \RuntimeException('No se puede editar: el movimiento deja el stock en negativo.');
            }
            $productoNuevo->stock = $nuevoStock;
            $productoNuevo->save();
        });

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Movimiento de stock actualizado correctamente');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $movimiento = MovimientoStock::lockForUpdate()->findOrFail($id);
            $producto = Producto::lockForUpdate()->findOrFail($movimiento->producto_id);

            $delta = 0;
            if ($movimiento->tipo === 'entrada') {
                $delta = $movimiento->cantidad;
            } elseif ($movimiento->tipo === 'salida') {
                $delta = -$movimiento->cantidad;
            } elseif ($movimiento->tipo === 'ajuste') {
                $delta = $movimiento->cantidad;
            }

            $producto->stock = ((int) $producto->stock) - $delta;
            if ($producto->stock < 0) {
                throw new \RuntimeException('No se puede eliminar: revertir el movimiento deja stock negativo.');
            }
            $producto->save();

            $movimiento->delete();
        });

        return redirect()->route('movimientos_stock.index')->with('mensaje', 'Movimiento de stock eliminado correctamente');
    }
}

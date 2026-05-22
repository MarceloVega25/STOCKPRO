<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\MovimientoStock;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\SeguimientoCompra;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with(['proveedor'])
            ->orderBy('id', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create', [
            'proveedores' => Proveedor::orderBy('nombre_apellido')->get(),
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'fecha' => 'required|date',
            'comprobante' => 'nullable|string|max:255',
            'proveedor_id' => 'required|exists:proveedores,id',
            'observaciones' => 'nullable|string',
            'producto_id' => 'required|array|min:1',
            'producto_id.*' => 'nullable|exists:productos,id',
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'nullable|integer|min:1',
            'precio_unitario' => 'required|array|min:1',
            'precio_unitario.*' => 'nullable|numeric|min:0',
        ]);

        $compra = null;

        DB::transaction(function () use ($request, &$compra) {
            $compra = Compra::create($request->only([
                'numero',
                'anio',
                'fecha',
                'comprobante',
                'proveedor_id',
                'observaciones',
            ]));

            $total = 0;

            $productoIds = $request->input('producto_id', []);
            $cantidades = $request->input('cantidad', []);
            $precios = $request->input('precio_unitario', []);

            $tieneItems = false;

            foreach ($productoIds as $i => $productoId) {
                if (!$productoId) {
                    continue;
                }

                $cantidad = (int) ($cantidades[$i] ?? 0);
                $precioUnitario = (float) ($precios[$i] ?? 0);
                $subtotal = $cantidad * $precioUnitario;

                $tieneItems = true;

                $item = new CompraItem();
                $item->compra_id = $compra->id;
                $item->producto_id = $productoId;
                $item->cantidad = $cantidad;
                $item->precio_unitario = $precioUnitario;
                $item->subtotal = $subtotal;
                $item->save();

                $producto = Producto::lockForUpdate()->findOrFail($productoId);
                $producto->stock = ((int) $producto->stock) + $cantidad;
                $producto->save();

                MovimientoStock::create([
                    'producto_id' => $productoId,
                    'compra_id' => $compra->id,
                    'tipo' => 'entrada',
                    'cantidad' => $cantidad,
                    'fecha' => $request->fecha,
                    'motivo' => 'Compra',
                    'usuario_id' => Auth::id(),
                ]);

                $total += $subtotal;
            }

            if (!$tieneItems) {
                throw new \RuntimeException('Debe cargar al menos un item.');
            }

            $compra->total = $total;
            $compra->save();

            $detalle = "Compra creada: N° {$compra->numero}/{$compra->anio}, Proveedor: " . optional($compra->proveedor)->nombre_apellido;
            SeguimientoCompra::create([
                'compra_id' => $compra->id,
                'accion' => 'Compra creada',
                'detalle' => Str::limit($detalle, 1000),
                'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
            ]);
        });

        return redirect()->route('compras.index')->with('mensaje', 'Compra creada correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load(['proveedor', 'items.producto', 'seguimientos']);

        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $compra->load(['items']);

        return view('compras.edit', [
            'compra' => $compra,
            'proveedores' => Proveedor::orderBy('nombre_apellido')->get(),
            'productos' => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'fecha' => 'required|date',
            'comprobante' => 'nullable|string|max:255',
            'proveedor_id' => 'required|exists:proveedores,id',
            'observaciones' => 'nullable|string',
            'producto_id' => 'required|array|min:1',
            'producto_id.*' => 'nullable|exists:productos,id',
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'nullable|integer|min:1',
            'precio_unitario' => 'required|array|min:1',
            'precio_unitario.*' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $compra) {
            $itemsPrevios = $compra->items()->get();
            foreach ($itemsPrevios as $itemPrevio) {
                $producto = Producto::lockForUpdate()->findOrFail($itemPrevio->producto_id);
                $producto->stock = ((int) $producto->stock) - ((int) $itemPrevio->cantidad);
                if ($producto->stock < 0) {
                    throw new \RuntimeException('La actualización deja el stock en negativo.');
                }
                $producto->save();
            }

            MovimientoStock::where('compra_id', $compra->id)->delete();
            $compra->items()->delete();

            $compra->update($request->only([
                'numero',
                'anio',
                'fecha',
                'comprobante',
                'proveedor_id',
                'observaciones',
            ]));

            $total = 0;
            $productoIds = $request->input('producto_id', []);
            $cantidades = $request->input('cantidad', []);
            $precios = $request->input('precio_unitario', []);

            $tieneItems = false;

            foreach ($productoIds as $i => $productoId) {
                if (!$productoId) {
                    continue;
                }
                $cantidad = (int) ($cantidades[$i] ?? 0);
                $precioUnitario = (float) ($precios[$i] ?? 0);
                $subtotal = $cantidad * $precioUnitario;

                $tieneItems = true;

                CompraItem::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $productoId,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ]);

                $producto = Producto::lockForUpdate()->findOrFail($productoId);
                $producto->stock = ((int) $producto->stock) + $cantidad;
                $producto->save();

                MovimientoStock::create([
                    'producto_id' => $productoId,
                    'compra_id' => $compra->id,
                    'tipo' => 'entrada',
                    'cantidad' => $cantidad,
                    'fecha' => $request->fecha,
                    'motivo' => 'Compra',
                    'usuario_id' => Auth::id(),
                ]);

                $total += $subtotal;
            }

            if (!$tieneItems) {
                throw new \RuntimeException('Debe cargar al menos un item.');
            }

            $compra->total = $total;
            $compra->save();

            $detalle = "Compra actualizada: N° {$compra->numero}/{$compra->anio}";
            SeguimientoCompra::create([
                'compra_id' => $compra->id,
                'accion' => 'Compra actualizada',
                'detalle' => Str::limit($detalle, 1000),
                'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
            ]);
        });

        return redirect()->route('compras.index')->with('mensaje', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        DB::transaction(function () use ($compra) {
            $items = $compra->items()->get();
            foreach ($items as $item) {
                $producto = Producto::lockForUpdate()->findOrFail($item->producto_id);
                $producto->stock = ((int) $producto->stock) - ((int) $item->cantidad);
                if ($producto->stock < 0) {
                    throw new \RuntimeException('No se puede eliminar: deja stock en negativo.');
                }
                $producto->save();
            }

            MovimientoStock::where('compra_id', $compra->id)->delete();
            $compra->items()->delete();
            $compra->delete();
        });

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

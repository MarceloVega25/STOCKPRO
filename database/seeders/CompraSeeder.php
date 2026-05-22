<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\{
    Compra,
    Proveedor,
    Producto,
    CompraItem,
    MovimientoStock,
    SeguimientoCompra
};

class CompraSeeder extends Seeder
{
    public function run(): void
    {
        if (Proveedor::count() === 0) {
            Proveedor::factory()->count(10)->create();
        }
        if (Producto::count() === 0) {
            Producto::factory()->count(20)->create();
        }

        $compras = Compra::factory()->count(15)->create([
            'anio' => now()->year,
            'proveedor_id' => Proveedor::inRandomOrder()->first()->id,
            'fecha' => now()->toDateString(),
        ]);

        foreach ($compras as $compra) {
            $total = 0;

            $productos = Producto::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($productos as $p) {
                $cantidad = rand(1, 10);
                $precioUnitario = (float) $p->precio;
                $subtotal = $cantidad * $precioUnitario;

                CompraItem::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $p->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ]);

                $p->stock = ((int) $p->stock) + $cantidad;
                $p->save();

                MovimientoStock::create([
                    'producto_id' => $p->id,
                    'compra_id' => $compra->id,
                    'tipo' => 'entrada',
                    'cantidad' => $cantidad,
                    'fecha' => $compra->fecha ?? Carbon::now(),
                    'motivo' => 'Compra (Seeder)',
                    'usuario_id' => null,
                ]);

                $total += $subtotal;
            }

            $compra->total = $total;
            $compra->save();

            SeguimientoCompra::create([
                'compra_id' => $compra->id,
                'accion' => 'Compra creada (Seeder)',
                'detalle' => 'Se generó una compra con items y se actualizó el stock.',
                'usuario' => 'Seeder',
                'fecha' => Carbon::now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\{
    Compra,
    Cliente,
    Venta,
    Departamento,
    Carrera,
    Proveedor,
    Reparto,
    Vehiculo,
    Vendedor,
    SeguimientoCompra
};

class CompraSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurar mínimos para relaciones (sin truncar para no borrar datos reales)
        if (Cliente::count() === 0) {
            Cliente::factory()->count(5)->create();
        }
        if (Venta::count() === 0) {
            Venta::factory()->count(10)->create();
        }
        if (Departamento::count() === 0) {
            Departamento::factory()->count(5)->create();
        }
        if (Carrera::count() === 0) {
            Carrera::factory()->count(8)->create();
        }
        if (Proveedor::count() === 0) {
            Proveedor::factory()->count(10)->create();
        }
        if (Reparto::count() === 0) {
            Reparto::factory()->count(12)->create();
        }
        if (Vehiculo::count() === 0) {
            Vehiculo::factory()->count(12)->create();
        }
        if (Vendedor::count() === 0) {
            Vendedor::factory()->count(8)->create();
        }

        $compras = Compra::factory()->count(15)->create([
            'anio' => now()->year,
            'cliente_id' => Cliente::inRandomOrder()->first()->id,
            'designado_id' => Proveedor::inRandomOrder()->first()->id,
        ]);

        foreach ($compras as $compra) {
            $ventaIds = Venta::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray();
            $deptoIds = Departamento::inRandomOrder()->limit(rand(1, 2))->pluck('id')->toArray();
            $carreraIds = Carrera::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray();
            $vendedorIds = Vendedor::inRandomOrder()->limit(rand(1, 2))->pluck('id')->toArray();
            $proveedorIds = Proveedor::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray();

            $compra->ventas()->sync($ventaIds);
            $compra->departamentos()->sync($deptoIds);
            $compra->carreras()->sync($carreraIds);
            $compra->vendedores()->sync($vendedorIds);
            $compra->proveedores()->sync($proveedorIds);

            // Repartos (titular/suplente)
            $titularRepartoIds = Reparto::inRandomOrder()->limit(rand(1, 2))->pluck('id')->toArray();
            $suplenteRepartoIds = Reparto::whereNotIn('id', $titularRepartoIds)->inRandomOrder()->limit(rand(0, 1))->pluck('id')->toArray();

            foreach ($titularRepartoIds as $id) {
                $compra->repartos()->attach($id, ['tipo' => 'titular']);
            }
            foreach ($suplenteRepartoIds as $id) {
                $compra->repartos()->attach($id, ['tipo' => 'suplente']);
            }

            // Vehiculos (titular/suplente)
            $titularVehiculoIds = Vehiculo::inRandomOrder()->limit(rand(1, 2))->pluck('id')->toArray();
            $suplenteVehiculoIds = Vehiculo::whereNotIn('id', $titularVehiculoIds)->inRandomOrder()->limit(rand(0, 1))->pluck('id')->toArray();

            foreach ($titularVehiculoIds as $id) {
                $compra->vehiculos()->attach($id, ['tipo' => 'titular']);
            }
            foreach ($suplenteVehiculoIds as $id) {
                $compra->vehiculos()->attach($id, ['tipo' => 'suplente']);
            }

            // Estados/seguimientos coherentes
            $compra->registrarEstado('Compra creada (Seeder)', 'Carga inicial de datos de prueba.');

            SeguimientoCompra::create([
                'compra_id' => $compra->id,
                'accion' => 'Compra creada (Seeder)',
                'detalle' => 'Se generó una compra con sus relaciones (ventas/repartos/vehículos/vendedores/proveedores).',
                'usuario' => 'Seeder',
                'fecha' => Carbon::now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Categoria,
    Cliente,
    Venta,
    Departamento,
    Carrera,
    Reparto,
    Vehiculo,
    Vendedor,
    Producto
};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Categoria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $cliente = Cliente::firstOrCreate(
            ['cuit' => '20-00000000-0'],
            ['razon_social' => 'Cliente de prueba', 'email' => 'cliente@example.com']
        );

        $venta = Venta::firstOrCreate(
            ['siglas' => 'GEO'],
            ['nombre' => 'Geomorfología']
        );

        $departamento = Departamento::firstOrCreate(
            ['siglas' => 'MA'],
            ['nombre' => 'Medio Ambiente']
        );

        $carrera1 = Carrera::firstOrCreate(
            ['siglas' => 'IA'],
            ['nombre' => 'Ingeniería en Agrimensura']
        );

        $carrera2 = Carrera::firstOrCreate(
            ['siglas' => 'IAM'],
            ['nombre' => 'Ingeniería Ambiental']
        );

        $docente1 = Reparto::factory()->create();
        $docente2 = Reparto::factory()->create();
        $estudiante1 = Vehiculo::factory()->create();
        $veedor1 = Vendedor::factory()->create();
        $producto1 = Producto::factory()->create();

        $categoria = Categoria::create([
            'numero' => 101,
            'anio' => 2026,
            'inicio_publicidad' => Carbon::now()->subDays(10),
            'cierre_publicidad' => Carbon::now()->subDays(5),
            'inicio_inscripcion' => Carbon::now()->subDays(4),
            'cierre_inscripcion' => Carbon::now()->addDays(5),
            'fecha_concurso' => Carbon::now()->addDays(15),
            'cliente_id' => $cliente->id,
            'tipo_concurso' => 'Ordinario',
            'modalidad_concurso' => 'Presencial',
            'expediente' => 'EXP-2026-0001',
            'observaciones' => 'Categoría simulada para pruebas.',
        ]);

        $categoria->asignaturas()->attach($venta->id);
        $categoria->departamentos()->attach($departamento->id);
        $categoria->carreras()->attach([$carrera1->id, $carrera2->id]);
        $categoria->docentes()->attach([
            $docente1->id => ['tipo' => 'titular'],
            $docente2->id => ['tipo' => 'suplente'],
        ]);
        $categoria->estudiantes()->attach([$estudiante1->id => ['tipo' => 'titular']]);
        $categoria->veedores()->attach($veedor1->id);
        $categoria->productos()->attach($producto1->id);

        $categoria->registrarEstado('Categoría creada automáticamente', 'Seeder de prueba.');
    }
}

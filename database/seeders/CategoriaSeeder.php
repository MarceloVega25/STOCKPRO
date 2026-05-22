<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Categoria, Producto};
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Categoria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categorias = Categoria::factory()->count(8)->create();

        $productos = Producto::all();
        if ($productos->count()) {
            foreach ($productos as $producto) {
                $producto->update(['categoria_id' => $categorias->random()->id]);
            }
        }
    }
}

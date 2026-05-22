<?php
namespace Database\Seeders;


use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        if (Categoria::count() === 0) {
            Categoria::factory()->count(5)->create();
        }

        Producto::factory()->count(25)->create();
        
    }
}

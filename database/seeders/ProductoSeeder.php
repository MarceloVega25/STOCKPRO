<?php
namespace Database\Seeders;


use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::factory()->count(25)->create();
        
    }
}

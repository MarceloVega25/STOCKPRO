<?php

namespace Database\Seeders;

use App\Models\Vendedor;
use Illuminate\Database\Seeder;

class VendedorSeeder extends Seeder
{
    public function run(): void
    {
        Vendedor::factory()->count(25)->create();
    }
}

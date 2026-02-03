<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crear y asignar rol admin
        $admin = Usuario::factory()->create([
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        $admin = Usuario::factory()->create([
            'email' => 'marcelovega614@gmail.com',
        ]);
        $admin->assignRole('admin');

        // Crear y asignar rol carga
        $carga = Usuario::factory()->create([
            'email' => 'carga@example.com',
        ]);
        $carga->assignRole('carga');

        // Crear y asignar rol consulta
        $consulta = Usuario::factory()->create([
            'email' => 'consulta@example.com',
        ]);
        $consulta->assignRole('consulta');

        // Crear 2 usuarios adicionales sin rol asignado (opcional)
        Usuario::factory()->count(2)->create();
    }
}

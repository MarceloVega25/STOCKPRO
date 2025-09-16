<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auditoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AuditoriaSeeder extends Seeder
{
    public function run(): void
    {
        // Opcional: Limpia antes de insertar
        Schema::disableForeignKeyConstraints();
        DB::table('auditorias')->truncate();
        Schema::enableForeignKeyConstraints();

        $usuarios = DB::table('usuarios')->pluck('id')->take(3); // Usa 3 usuarios

        $fechas = collect(range(0, 9))->map(fn ($i) => Carbon::now()->subDays($i)->format('Y-m-d H:i:s'));

        foreach ($fechas as $i => $fecha) {
            Auditoria::create([
                'tabla_afectada' => ['docentes', 'inscriptos', 'concursos'][$i % 3],
                'operacion' => ['INSERT', 'UPDATE', 'DELETE'][$i % 3],
                'registro_id' => rand(1, 50),
                'datos_anteriores' => json_encode(['campo' => 'valor anterior']),
                'datos_nuevos' => json_encode(['campo' => 'valor nuevo']),
                'usuario_id' => $usuarios[$i % $usuarios->count()],
                'fecha' => $fecha,
            ]);
        }
    }
}

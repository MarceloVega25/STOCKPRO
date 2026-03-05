<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compra>
 */
class CompraFactory extends Factory
{
    protected $model = Compra::class;

    public function definition(): array
    {
        return [
            'numero' => $this->faker->unique()->numberBetween(1, 999),
            'anio' => now()->year,
            'inicio_publicidad' => Carbon::now()->subDays(10),
            'cierre_publicidad' => Carbon::now()->subDays(5),
            'inicio_inscripcion' => Carbon::now()->subDays(4),
            'cierre_inscripcion' => Carbon::now()->addDays(5),
            'fecha_compra' => Carbon::now()->addDays(15),
            'cliente_id' => Cliente::inRandomOrder()->first()?->id ?? Cliente::factory(),
            'tipo_compra' => $this->faker->randomElement(['Ordinario', 'Reválida', 'Interino']),
            'modalidad_compra' => $this->faker->randomElement(['Presencial', 'Virtual', 'Mixta']),
            'expediente' => 'EXP-' . $this->faker->unique()->numerify('2024-####'),
            'observaciones' => $this->faker->sentence(),
        ];
    }
}

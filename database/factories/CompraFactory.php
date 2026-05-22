<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Proveedor;
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
            'fecha' => Carbon::now()->subDays(rand(0, 15))->toDateString(),
            'comprobante' => 'COMP-' . $this->faker->unique()->numerify('########'),
            'proveedor_id' => Proveedor::inRandomOrder()->first()?->id ?? Proveedor::factory(),
            'observaciones' => $this->faker->sentence(),
            'total' => 0,
        ];
    }
}

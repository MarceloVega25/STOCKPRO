<?php

namespace Database\Factories;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word(),
            'siglas' => $this->faker->unique()->lexify('???'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Repartidor;
use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reparto>
 */
class RepartoFactory extends Factory
{
    protected $model = Reparto::class;

    public function definition(): array
    {
        return [
            'compra_id' => Compra::query()->inRandomOrder()->value('id') ?? Compra::factory(),
            'repartidor_id' => Repartidor::query()->inRandomOrder()->value('id') ?? Repartidor::factory(),
            'vehiculo_id' => Vehiculo::query()->inRandomOrder()->value('id'),
            'fecha_reparto' => $this->faker->dateTimeBetween('-15 days', '+5 days'),
            'estado' => $this->faker->randomElement(['pendiente', 'en_camino', 'entregado', 'cancelado']),
            'direccion_entrega' => $this->faker->streetAddress(),
            'observaciones' => $this->faker->optional()->sentence(),
        ];
    }
}

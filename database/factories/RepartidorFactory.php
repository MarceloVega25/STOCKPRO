<?php

namespace Database\Factories;

use App\Models\Repartidor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repartidor>
 */
class RepartidorFactory extends Factory
{
    protected $model = Repartidor::class;

    public function definition(): array
    {
        return [
            'nombre_apellido' => $this->faker->name(),
            'dni' => $this->faker->unique()->numerify('########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'),
            'genero' => $this->faker->randomElement(['masculino', 'femenino', 'otro']),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numerify('##########'),
            'institucion' => $this->faker->company(),
            'tipo' => $this->faker->randomElement(['titular', 'suplente']),
            'cv' => $this->faker->uuid() . '.pdf',
            'fotografia' => $this->faker->uuid() . '.' . $this->faker->randomElement(['jpg', 'jpeg', 'png']),
        ];
    }
}

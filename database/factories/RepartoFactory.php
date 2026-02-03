<?php

namespace Database\Factories;

use App\Models\Reparto;
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
            'nombre_apellido' => $this->faker->name(),
            'dni' => $this->faker->unique()->numerify('########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'),
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numerify('##########'),
            'institucion' => $this->faker->company(),
            'tipo' => $this->faker->randomElement(['Titular', 'Suplente']),
            'cv' => $this->faker->uuid() . '.pdf',
            'fotografia' => $this->faker->uuid() . '.' . $this->faker->randomElement(['jpg', 'jpeg', 'png']),
        ];
    }
}

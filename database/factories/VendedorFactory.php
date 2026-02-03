<?php

namespace Database\Factories;

use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendedor>
 */
class VendedorFactory extends Factory
{
    protected $model = Vendedor::class;

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
            'cargo' => $this->faker->randomElement(['Jurado', 'Vendedor', 'Presidente', 'Secretario Técnico']),
            'cv' => $this->faker->uuid() . '.pdf',
            'fotografia' => $this->faker->uuid() . '.' . $this->faker->randomElement(['jpg', 'jpeg', 'png']),
        ];
    }
}

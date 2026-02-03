<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition(): array
    {
        return [
            'nombre_apellido' => $this->faker->name(),
            'dni' => $this->faker->unique()->numerify('########'),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'),
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numerify('##########'),
            'direccion' => $this->faker->address(),
            'localidad_ciudad' => $this->faker->city(),
            'cv' => $this->faker->uuid() . '.pdf',
            'fotografia' => $this->faker->uuid() . '.' . $this->faker->randomElement(['jpg', 'jpeg', 'png']),
        ];
    }
}

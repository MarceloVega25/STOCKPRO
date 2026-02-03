<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'razon_social' => $this->faker->unique()->company(),
            'cuit' => $this->faker->unique()->numerify('##-########-#'),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numerify('##########'),
            'direccion' => $this->faker->streetAddress(),
            'localidad_ciudad' => $this->faker->city(),
            'condicion_iva' => $this->faker->randomElement(['Responsable', 'Monotributo', 'Exento']),
        ];
    }
}

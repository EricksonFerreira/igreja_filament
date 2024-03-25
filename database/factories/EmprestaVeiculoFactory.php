<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmprestaVeiculo>
 */
class EmprestaVeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'veiculo_id' => fake()->numberBetween(1,10), // Genera un ID de veículo ficticio (ajusta según tus necesidades).
            'preco_id' => fake()->numberBetween(1,10),   // Genera un ID de precio ficticio (ajusta según tus necesidades).
            'user_id' => fake()->numberBetween(1,10),    // Genera un ID de usuario ficticio (ajusta según tus necesidades).
            'data' => fake()->date,
        ];
    }
}

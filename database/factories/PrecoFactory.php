<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preco>
 */
class PrecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name,
            'valor' =>  fake()->randomFloat(2, 10, 500),
            'veiculo_id' => fake()->numberBetween(1,10),

        ];
    }
}

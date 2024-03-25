<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Local>
 */
class LocalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name,        // Genera un nombre ficticio
            'endereco' => fake()->address, // Genera una dirección ficticia
            'numero' => fake()->buildingNumber, // Genera un número de edificio ficticio
            'cep' => fake()->postcode,    // Genera un código postal ficticio
        ];
    }
}

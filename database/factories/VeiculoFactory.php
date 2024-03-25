<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veiculo>
 */
class VeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name,           // Genera un nombre ficticio.
            'placa' => $this->generateLicensePlate(),  // Genera una placa ficticia.
            'ano' => fake()->year,            // Genera un año ficticio.
            'ativo' => fake()->boolean,       // Genera un valor booleano ficticio.
            'marca_id' => fake()->randomDigitNotNull,  // Genera un ID de marca ficticio (cambiar según tus necesidades).
        ];
    }
    function generateLicensePlate()
    {
        // Lógica para generar una placa ficticia, por ejemplo: ABC-1234
        $letters = strtoupper(2);
        // $numbers = str_random(4);

        return $letters;
    }
}

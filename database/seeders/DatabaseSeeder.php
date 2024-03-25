<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Local::factory(10)->create();
        \App\Models\Marca::factory(10)->create();
        \App\Models\User::factory(50)->create();
        \App\Models\Veiculo::factory(10)->create();
        \App\Models\Preco::factory(10)->create();
        \App\Models\EmprestaVeiculo::factory(10)->create();

        $this->call(TiposCultoTableSeeder::class);
        $this->call(CultoTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(StatusMembroTableSeeder::class);
        $this->call(EstadoCivilTableSeeder::class);
        $this->call(MembroTableSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

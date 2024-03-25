<?php

namespace Database\Seeders;

use App\Models\TiposCulto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TiposCultoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiposCulto::insert([
            ['nome' => 'Culto Matutino', 'ativo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nome' => 'Culto Vespertino', 'ativo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nome' => 'Culto Familiar', 'ativo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nome' => 'Culto de Ações de Graças', 'ativo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nome' => 'Culto UMP', 'ativo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}

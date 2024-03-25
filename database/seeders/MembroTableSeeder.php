<?php

namespace Database\Seeders;

use App\Models\Membro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Membro::insert(
            [
                'status_membro_id'=>1,'nome'=>'Erickson Ferreira','data_nasc'=>'1999-01-15',
                'sexo'=>'M','batizado'=>1,'professou_fe'=>1,'data_batismo'=>null,
                'data_profissao_fe'=>null,'estado_civil_id'=>1
            ]
        );
    }
}

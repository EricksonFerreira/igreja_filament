<?php

namespace Database\Seeders;

use App\Models\EstadoCivil;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCivilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estado_civis = [
            ['badges_classes'=>'primary','nome'=>'Solteiro'],
            ['badges_classes'=>'secondary','nome'=>'Casado'],
            ['badges_classes'=>'warning','nome'=>'Viuvo'],
            ['badges_classes'=>'danger','nome'=>'Divorciado']
        ];

        foreach ($estado_civis as &$estado_civil) {
            $estado_civil['created_at'] = Carbon::now();
            $estado_civil['updated_at'] = Carbon::now();
        }

        EstadoCivil::insert($estado_civis);
    }
}

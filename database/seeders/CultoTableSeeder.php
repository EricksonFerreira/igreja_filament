<?php

namespace Database\Seeders;

use App\Models\Culto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CultoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cultos = [
            ['inicio_evento'=>null,'fim_evento'=>null,'prev_inicio_evento' => '2024-02-11 09:30:00', 'prev_fim_evento'=>'2024-02-11 10:30:00','tipo_culto_id' => 1, 'evento_agendado' => 1, 'evento_ocorreu' => 0],
            ['inicio_evento'=>null,'fim_evento'=>null,'prev_inicio_evento' => '2024-02-11 17:00:00', 'prev_fim_evento'=>'2024-02-11 18:30:00','tipo_culto_id' => 2, 'evento_agendado' => 1, 'evento_ocorreu' => 0],
            ['inicio_evento'=>null,'fim_evento'=>null,'prev_inicio_evento' => '2024-02-16 19:00:00', 'prev_fim_evento'=>'2024-02-11 20:30:00','tipo_culto_id' => 3, 'evento_agendado' => 1, 'evento_ocorreu' => 0],
            ['inicio_evento'=>null,'fim_evento'=>null,'prev_inicio_evento' => '2024-02-17 19:00:00', 'prev_fim_evento'=>'2024-02-11 20:30:00','tipo_culto_id' => 4, 'evento_agendado' => 1, 'evento_ocorreu' => 0],
        ];

        foreach ($cultos as &$culto) {
            $culto['created_at'] = Carbon::now();
            $culto['updated_at'] = Carbon::now();
        }

        Culto::insert($cultos);

    }
}

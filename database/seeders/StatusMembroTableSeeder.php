<?php

namespace Database\Seeders;

use App\Models\StatusMembro;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusMembroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusMembro = [
            ['nome'=>'Ativo'],
            ['nome'=>'Disciplina'],
            ['nome'=>'Férias'],
            ['nome'=>'Excomungado'],
            ['nome'=>'Saiu da Igreja']
        ];

        foreach ($statusMembro as &$status) {
            $status['created_at'] = Carbon::now();
            $status['updated_at'] = Carbon::now();
        }
        StatusMembro::insert($statusMembro);
    }
}

<?php

namespace App\Filament\Resources\CultoResource\Pages;

use App\Filament\Resources\CultoResource;
use App\Models\Membro;
use App\Models\Participacao;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCulto extends CreateRecord
{
    protected static string $resource = CultoResource::class;

    protected function afterCreate():void {
        $cultoId = $this->record['id'];
        $this->adiciona_membros_culto($cultoId);
    }
    private function adiciona_membros_culto($culto_id){
        // Obtenha todos os membros
        $membros = Membro::where('status_membro_id',1)->get();

        // Adicione cada membro à tabela de presença do culto
        foreach ($membros as $membro) {
            Participacao::firstOrCreate([
                'culto_id' => $culto_id,
                'membro_id' => $membro->id,
            ]);
        }
    }

}

<?php

namespace App\Filament\Resources\TiposCultoResource\Pages;

use App\Filament\Resources\TiposCultoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTiposCultos extends ManageRecords
{
    protected static string $resource = TiposCultoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Tipo de Membro')->icon('heroicon-m-plus-circle'),
        ];
    }
}

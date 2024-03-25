<?php

namespace App\Filament\Resources\StatusMembroResource\Pages;

use App\Filament\Resources\StatusMembroResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatusMembros extends ManageRecords
{
    protected static string $resource = StatusMembroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Status de Membro')->icon('heroicon-m-plus-circle'),
        ];
    }
}

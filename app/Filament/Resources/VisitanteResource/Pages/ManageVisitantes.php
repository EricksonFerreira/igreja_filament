<?php

namespace App\Filament\Resources\VisitanteResource\Pages;

use App\Filament\Resources\VisitanteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitantes extends ManageRecords
{
    protected static string $resource = VisitanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Visitante')->icon('heroicon-m-plus-circle'),
        ];
    }
}

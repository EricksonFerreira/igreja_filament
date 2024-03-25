<?php

namespace App\Filament\Resources\MarcasResource\Pages;

use App\Filament\Resources\MarcasResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMarcas extends ManageRecords
{
    protected static string $resource = MarcasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PrecoResource\Pages;

use App\Filament\Resources\PrecoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePrecos extends ManageRecords
{
    protected static string $resource = PrecoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

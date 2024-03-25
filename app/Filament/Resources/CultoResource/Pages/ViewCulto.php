<?php

namespace App\Filament\Resources\CultoResource\Pages;

use App\Filament\Resources\CultoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCulto extends ViewRecord
{
    protected static string $resource = CultoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Editar'),
        ];
    }
}

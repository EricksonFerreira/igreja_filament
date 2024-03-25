<?php

namespace App\Filament\Resources\CultoResource\Pages;

use App\Filament\Resources\CultoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCulto extends EditRecord
{
    protected static string $resource = CultoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

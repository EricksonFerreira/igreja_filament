<?php

namespace App\Filament\Resources\MembroResource\Pages;

use App\Filament\Resources\MembroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMembro extends EditRecord
{
    protected static string $resource = MembroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Apagar'),
        ];
    }
}

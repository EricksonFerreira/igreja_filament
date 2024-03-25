<?php

namespace App\Filament\Resources\CultoResource\Pages;

use App\Filament\Resources\CultoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCultos extends ListRecords
{
    protected static string $resource = CultoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Culto')->icon('heroicon-m-plus-circle'),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Todos'=>Tab::make()->icon('heroicon-o-bars-4'),
            'Houve Culto'=>Tab::make()->icon('heroicon-o-check-circle')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('evento_ocorreu', true)),
            'Não houve Culto'=>Tab::make()->icon('heroicon-o-x-circle')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('evento_ocorreu', false)),
        ];
    }
}

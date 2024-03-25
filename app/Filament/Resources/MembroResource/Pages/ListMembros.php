<?php

namespace App\Filament\Resources\MembroResource\Pages;

use App\Filament\Resources\MembroResource;
use App\Models\Membro;
use App\Traits\hasTableManOrWolmanTabs;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListMembros extends ListRecords
{
    protected static string $resource = MembroResource::class;
// use hasTableManOrWolmanTabs;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("Novo Membro")->icon('heroicon-m-plus-circle'),
        ];
    }

    public function getTabs(): array
    {
        $total = Membro::count();
        $countHomens = Membro::where(['sexo'=>'M'])->count();
        $countMulheres = Membro::where(['sexo'=>'F'])->count();

        return [
            'Todos'=>Tab::make()->icon('heroicon-o-bars-4')->badge($total),
            'Homens'=>Tab::make()->icon('')->badge($countHomens)
            ->modifyQueryUsing(fn (Builder $query) =>$query->where('sexo','M')),
            'Mulheres'=>Tab::make()->badge($countMulheres)
            ->modifyQueryUsing(fn (Builder $query) =>$query->where('sexo','F')),
        ];
    }
}

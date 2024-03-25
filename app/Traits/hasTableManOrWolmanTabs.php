<?php

namespace App\Traits;

trait hasTableManOrWolmanTabs {
    public function getTabs():array{
        return [
            'Todos'=>Tab::make(),
            'Homens'=>Tab::make()
            ->modifyQueryUsing(fn (Builder $query) =>$query->where('sexo','M')),
            'Mulheres'=>Tab::make()
            ->modifyQueryUsing(fn (Builder $query) =>$query->where('sexo','F')),
        ]
    }

}

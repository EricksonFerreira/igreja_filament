<?php

namespace App\Filament\Resources\CultoResource\RelationManagers;

use App\Models\MembroCulto;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembrosRelationManager extends RelationManager
{
    protected static string $relationship = 'membros';
    protected static ?string $icon = 'heroicon-o-user-circle';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            Forms\Components\Toggle::make('participou')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome')
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\ToggleColumn::make('participou'),
                Tables\Columns\ToggleColumn::make('entrei_contato'),
                Tables\Columns\TextInputColumn::make('detalhe')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\AssociateAction::make()->preloadRecordSelect(),
                Tables\Actions\AttachAction::make()->color('primary')->icon('heroicon-o-plus-circle')->label('Vincular Membro'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DissociateAction::make(),
                 Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make()
                // ->recordSelect(
                //     fn (Select $select) => $select->placeholder('Não houve membros para o culto'),
                // ),
            ]);
    }
    public function associate($record, $relatedKey, $managerData)
    {
    // Adiciona a associação entre o culto e o membro utilizando a tabela intermediária 'participa_culto'
    $record->membros()->attach($managerData['membro_id'], ['participou' => $managerData['participou']]);
    }

}

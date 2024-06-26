<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadoCivilResource\Pages;
use App\Filament\Resources\EstadoCivilResource\RelationManagers;
use App\Models\EstadoCivil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstadoCivilResource extends Resource
{
    protected static ?string $model = EstadoCivil::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gerenciamento Culto';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                ->label('Nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label("Editar"),
                Tables\Actions\DeleteAction::make()->label("Apagar"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label("Apagar"),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label("Novo Estado Civil")->icon('heroicon-m-plus-circle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEstadoCivils::route('/'),
        ];
    }
}

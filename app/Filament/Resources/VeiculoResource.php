<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VeiculoResource\Pages;
use App\Filament\Resources\VeiculoResource\RelationManagers;
use App\Models\Veiculo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;

class VeiculoResource extends Resource
{
    protected static ?string $model = Veiculo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Teste';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('marca.nome')
                    ->required(),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('placa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ano')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('ativo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('marca.nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('placa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ano')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVeiculos::route('/'),
            'create' => Pages\CreateVeiculo::route('/create'),
            'edit' => Pages\EditVeiculo::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrecoResource\Pages;
use App\Filament\Resources\PrecoResource\RelationManagers;
use App\Models\Preco;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;


class PrecoResource extends Resource
{
    protected static ?string $model = Preco::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Teste';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('veiculo.nome')
                    ->required(),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('valor')
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
                Tables\Columns\TextColumn::make('veiculo.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('valor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('veiculo')
                ->searchable()
                ->relationship('veiculo','nome')
                ->label("Veiculos:")
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePrecos::route('/'),
        ];
    }
}

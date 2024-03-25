<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusMembroResource\Pages;
use App\Filament\Resources\StatusMembroResource\RelationManagers;
use App\Models\StatusMembro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusMembroResource extends Resource
{
    protected static ?string $model = StatusMembro::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Gerenciamento Culto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
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
                Tables\Actions\EditAction::make()->label("Editar"),
                Tables\Actions\DeleteAction::make()->label("Apagar"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label("Apagar"),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label("Novo Status de Membro")->icon('heroicon-m-plus-circle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStatusMembros::route('/'),
        ];
    }
}

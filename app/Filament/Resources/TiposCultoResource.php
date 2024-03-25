<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TiposCultoResource\Pages;
use App\Filament\Resources\TiposCultoResource\RelationManagers;
use App\Models\TiposCulto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TiposCultoResource extends Resource
{
    protected static ?string $model = TiposCulto::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Gerenciamento Culto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')->required()->maxLength(255),
                Forms\Components\Toggle::make('ativo')->inline(false)->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->searchable(),
                ToggleColumn::make('ativo')->searchable(),
                TextColumn::make('created_at')->dateTime()->searchable()->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\CreateAction::make()->label("Novo Tipo de Culto")->icon('heroicon-m-plus-circle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTiposCultos::route('/'),
        ];
    }
}

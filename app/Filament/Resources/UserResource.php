<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Usuários';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([

                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->maxLength(255),
                            Fieldset::make("Configurações")->schema([

                                Forms\Components\Toggle::make('is_admin')->inline(false)->label('Administrador')
                                ->required(),
                                Forms\Components\Toggle::make('ativo')->inline(false)->label('Ativo')
                                ->required(),
                                ])->columns(2),
                                ])->columns(2),
                    Section::make([
                        DateTimePicker::make('created_at')
                            ->label('Criação')
                            // ->required()
                            ->disabled()
                            ->format('Y-m-d H:m'),

                        DateTimePicker::make('updated_at')
                            ->label('Última atualização')
                            ->disabled()
                            // ->required()
                            ->format('Y-m-d H:m'),
                    ])->grow(false),
                ])->from('md')
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')->label('Verificação E-mail')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')->label('Administrador')
                    ->boolean(),
                Tables\Columns\IconColumn::make('ativo')->label('Ativo')
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
                Tables\Actions\EditAction::make()->label("Editar"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label("Apagar"),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label("Adicionar Usuário")->icon('heroicon-m-plus-circle'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

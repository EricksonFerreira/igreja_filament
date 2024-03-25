<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitanteResource\Pages;
use App\Filament\Resources\VisitanteResource\RelationManagers;
use App\Models\Visitante;
use App\Models\Membro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitanteResource extends Resource
{
    protected static ?string $model = Visitante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Gerenciamento Culto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        Fieldset::make('Dados Pessoais')->schema([
                            Forms\Components\TextInput::make('nome')
                                ->label('Nome')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('sexo')
                                ->columns(1)
                                ->label('Sexo')
                                ->options([
                                    'M' => 'Masculino',
                                    'F' => 'Feminino',
                                ])
                                ->placeholder("Selecione uma das opções...")
                                ->required(),
                            Forms\Components\TextInput::make('telefone')
                                    ->label('Telefone')
                                ->mask(RawJs::make(<<<'JS'
                                    $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                JS)),
                            Select::make('membro_convidou_id')
                                ->label('Membro que convidou')
                                ->options(Membro::where('status_membro_id', 1)->get()->pluck('nome', 'id')),
                        ])->columns(3),
                    ]),
                    // Section::make([
                    //     DateTimePicker::make('created_at')
                    //         ->label('Criação')
                    //         // ->required()
                    //         ->disabled()
                    //         ->format('Y-m-d H:m'),

                    //     DateTimePicker::make('updated_at')
                    //         ->label('Última atualização')
                    //         ->disabled()
                    //         // ->required()
                    //         ->format('Y-m-d H:m'),
                    // ])->grow(false),
                ])->from('md')
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                ->searchable(),
                TextColumn::make('sexo')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'M' => 'success',
                    'F' => 'danger',
                }),
                TextColumn::make('telefone')
                ->searchable(),
                TextColumn::make('membro_convidou.nome')
                ->label('Membro que Convidou')
                ->badge()
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Apagar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Apagar'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Novo Visitante')->icon('heroicon-m-plus-circle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVisitantes::route('/'),
        ];
    }
}

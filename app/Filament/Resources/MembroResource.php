<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembroResource\Pages;
use App\Filament\Resources\MembroResource\RelationManagers;
use App\Models\EstadoCivil;
use App\Models\Membro;
use App\Models\StatusMembro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembroResource extends Resource
{
    protected static ?string $model = Membro::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
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
                                ->maxLength(255)
                            ->columns(3),
                            Forms\Components\Select::make('status_membro_id')
                                ->columns(1)
                                ->name('status_membro_id')
                                ->label('Status')
                                ->options(StatusMembro::all()->pluck('nome', 'id'))
                                ->placeholder("Selecione uma das opções...")
                                ->default(1)
                                ->required(),
                            Forms\Components\Select::make('estado_civil_id')
                                ->columns(1)
                                ->name('estado_civil_id')
                                ->label('Estado Civil')
                                ->options(EstadoCivil::all()->pluck('nome', 'id'))
                                ->placeholder("Selecione uma das opções...")
                                // ->default(1)
                                ->required(),
                            Forms\Components\DatePicker::make('data_nasc')
                                ->label('Data de Nascimento'),
                            Forms\Components\Select::make('sexo')
                                ->columns(1)
                                ->label('Sexo')
                                ->options([
                                    'M' => 'Masculino',
                                    'F' => 'Feminino',
                                ])
                                ->placeholder("Selecione uma das opções...")
                                ->required(),
                        ])->columns(3),
                        Fieldset::make('Batismo')->schema([
                            Forms\Components\Toggle::make('batizado')
                                ->label('Já foi batizado?')
                                ->inline(false)
                                ->required(),
                            Forms\Components\DatePicker::make('data_batismo')
                                ->label('Data de Batismo'),
                        ])->columns(2),
                        Fieldset::make('Profissão de Fé')->schema([
                            Forms\Components\Toggle::make('professou_fe')
                                ->label('Já professou fé?')
                                ->inline(false)
                                ->required(),
                            Forms\Components\DatePicker::make('data_profissao_fe')
                                ->label('Data da profissão de fé'),
                        ])->columns(2),
                    ]),
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
                TextColumn::make('status_membro.nome')
                    ->label('Status')
                    ->badge()
                    ->color(function (string $state): string {
                        switch ($state) {
                            case 'Ativo':
                                return 'success';
                            case 'Disciplina':
                                return 'primary';
                            case 'Férias':
                                return 'warning';
                            case 'Excomungado':
                                return 'danger';
                            case 'Saiu da Igreja':
                                return 'info';
                            default:
                                return 'secondary';
                        }
                    })
                    ->searchable(),
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('data_nasc')
                    ->label('Data Nascimento')
                    ->datetime('d/m/Y')->searchable(),
                TextColumn::make('sexo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'M' => 'success',
                        'F' => 'danger',
                    }),
                IconColumn::make('batizado')
                    ->boolean(),
                TextColumn::make('data_batismo')
                    ->label('Data Batismo')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->datetime('d/m/Y')->searchable(),
                IconColumn::make('professou_fe')
                    ->label('Professou a fé')
                    ->boolean(),
                TextColumn::make('data_profissao_fe')
                    ->label('Data da Profissão de Fé')
                    ->datetime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('estado_civil.nome')
                    ->label('Estado Civil')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y')
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
                    Tables\Actions\DeleteBulkAction::make()->label('Apagar'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Novo Membro'),
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
            'index' => Pages\ListMembros::route('/'),
            'create' => Pages\CreateMembro::route('/create'),
            'edit' => Pages\EditMembro::route('/{record}/edit'),
        ];
    }
}

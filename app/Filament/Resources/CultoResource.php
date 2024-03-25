<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CultoResource\Pages;
use App\Filament\Resources\CultoResource\RelationManagers;
use App\Filament\Resources\CultoResource\RelationManagers\MembrosRelationManager;
use App\Filament\Resources\CultoResource\RelationManagers\VisitantesRelationManager;
use App\Models\Culto;
use App\Models\Membro;
use App\Models\Participacao;
use App\Models\TiposCulto;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as Section2;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

class CultoResource extends Resource
{
    protected static ?string $model = Culto::class;

    protected static ?string $activeNavigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Gerenciamento Culto';

    public static $cultoId;

    public static function setCultoId($id)
    {
        static::$cultoId = $id;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        Select::make('tipo_culto_id')
                            ->label('Tipo de Culto')
                            ->options(TiposCulto::where('ativo', true)->get()->pluck('nome', 'id'))

                            // ->options([...]) // Opções devem ser preenchidas com os tipos de culto disponíveis
                            ->required(),
                        Fieldset::make('Datas Previstas')->schema([
                            DateTimePicker::make('prev_inicio_evento')
                            ->label('Previsão de Início do Evento')
                            ->required()
                            ->format('Y-m-d H:m'),

                            DateTimePicker::make('prev_fim_evento')
                            ->label('Previsão de Fim do Evento')
                            ->required()
                            ->format('Y-m-d H:m'),
                        ])->columns(2),
                        Fieldset::make('Datas Executadas')->schema([
                            DateTimePicker::make('inicio_evento')
                            ->label('Início do Evento')
                            // ->required()
                            ->format('Y-m-d H:m'),

                            DateTimePicker::make('fim_evento')
                            ->label('Fim do Evento')
                            // ->required()
                            ->format('Y-m-d H:m'),
                        ])->columns(2)
                    ])->grow(),
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
                    ])->grow(false)
                ])->from('md'),
            ])
            ->columns(1);

        // ]);
    }

    public static function create(Form $form)
    {
        $form = static::form($form);

        $form->onSave(function (Culto $culto) {
            // Salvar o culto
            $culto->save();

            // Obter o ID do culto criado
            $cultoId = $culto->id;

            // Adicionar membros ao culto
            static::adiciona_membros_culto($cultoId);
        });

        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('tipo_culto.nome')
                    ->label('Tipo de Culto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prev_inicio_evento')
                    ->label('Previsão Inicio/Fim')
                    ->description(function (Culto $culto) {
                        $prevFimEvento = Culto::firstWhere('id', $culto->id)?->prev_fim_evento;
                        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $prevFimEvento);
                        return $dateTime ? $dateTime->format('d/m/Y H:i') : null;
                    })
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                IconColumn::make('evento_agendado')->boolean(),
                TextColumn::make('inicio_evento')
                    ->label('Inicio/Fim')
                    ->description(function (Culto $culto) {
                        $fimEvento = Culto::firstWhere('id', $culto->id)?->fim_evento;
                        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $fimEvento);
                        return $dateTime ? $dateTime->format('d/m/Y H:i') : null;
                    })
                    ->dateTime('d/m/Y H:i'),
                IconColumn::make('evento_ocorreu')->boolean(),
            ])
            ->filters([
                SelectFilter::make('tipo_culto_id')
                    ->options(TiposCulto::where('ativo', 1)->get()->pluck('nome', 'id'))
                    ->multiple(),
                Filter::make('Iniciou atrasado')->query(
                    function ($query) {
                        return $query->where('prev_inicio_evento', '<', 'inicio_evento');
                    }
                ),
                Filter::make('Terminou atrasado')->query(
                    function ($query) {
                        return $query->where('prev_fim_evento', '<', 'fim_evento');
                    }
                ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label("Visualizar"),
                    Tables\Actions\EditAction::make()->label("Editar"),
                    Tables\Actions\DeleteAction::make()->label("Apagar"),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label("Apagar"),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label("Novo Culto")->icon('heroicon-m-plus-circle'),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            'membros' => MembrosRelationManager::class,
            'visitantes' => VisitantesRelationManager::class,
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        // $instance = new static();
        // dump($cultoId = static::$cultoId);
        // dd($instance);
        // $cultoId = $instance->cultoId;
        $culto = new CultoResource();
        return $infolist
            ->schema([
                // TextEntry::make('tipo_culto.nome')->size('lg')->weight('bold')->hiddenLabel(),
                Section2::make('Previsão dos horários')->schema([
                    TextEntry::make('prev_inicio_evento')
                        ->label('Previsão Inicio')
                        ->date('d/m/Y H:i'),
                    TextEntry::make('prev_fim_evento')
                        ->label('Previsão Fim')
                        ->date('d/m/Y H:i'),
                ])->columnSpan(1),
                Section2::make('Execução dos horários')->schema([
                    TextEntry::make('inicio_evento')
                        // ->default('Não iniciado ainda...')
                        ->date('d/m/Y H:i'),
                    TextEntry::make('fim_evento')
                        ->date('d/m/Y H:i'),
                ])->columnSpan(1),
                Section2::make('Totais')->schema([
                    TextEntry::make('Total de membros presentes')
                        ->badge()
                        ->default($culto->getTotalMembros(true))
                        ->color('success'),
                    TextEntry::make('Total de membros faltantes')
                        ->badge()
                        ->default($culto->getTotalMembros(false))
                        ->color('danger'),
                    TextEntry::make('Total de visitantes')
                        ->badge()
                        ->default($culto->getTotalVisitantes()),
                    // ->color(fn ($totalVisitantes) => $totalVisitantes > 0 ? 'success' : 'danger')
                ])->columnSpan(1),
            ])->columns(3);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCultos::route('/'),
            'create' => Pages\CreateCulto::route('/create'),
            'view' => Pages\ViewCulto::route('/{record}'),
            'edit' => Pages\EditCulto::route('/{record}/edit'),
        ];
    }
    public function getTotalMembros($participou)
    {
        $cultoId = Route::current()->parameter('record'); // obtém o id do culto da rota

        $participacoes = Participacao::where('culto_id', $cultoId)
            ->where('participou', $participou)
            ->where("visitante_id",null)
            ->count();

        // Usando o operador ternário para decidir o que exibir
        return ($participacoes > 0) ? $participacoes : 0;
    }

    // Falta criar a função
    public function getTotalVisitantes()
    {
        $cultoId = Route::current()->parameter('record'); // obtém o id do culto da rota

        $participacoes = Participacao::where('culto_id', $cultoId)
            ->where("visitante_id",'<>',null)
            ->count();

        // Usando o operador ternário para decidir o que exibir
        return ($participacoes > 0) ? $participacoes : 0;
    }
}

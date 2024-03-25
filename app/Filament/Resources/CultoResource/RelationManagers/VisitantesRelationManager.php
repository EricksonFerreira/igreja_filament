<?php

namespace App\Filament\Resources\CultoResource\RelationManagers;

use App\Models\Membro;
use App\Models\Participacao;
use App\Models\Visitante;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;

class VisitantesRelationManager extends RelationManager
{
    protected static string $relationship = 'visitantes';
    protected static ?string $icon = 'heroicon-o-user';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        $cultoId = 1;
        // $visitantesNaoAssociados = Visitante::whereNotIn('id', function ($query) use ($cultoId) {
        //     $query->select('visitante_id')
        //           ->from('participacoes')
        //           ->where('culto_id', $cultoId);
        // })->get();
        // Visitante::where('nome', 'like', '%' . $search . '%')->get();

        return $table
            ->recordTitleAttribute('nome')
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
                Tables\Columns\ToggleColumn::make('entrei_contato'),
                // TextInputColumn::make('detalhe')
                // ->editable()
                // ->inlineEditing(fn ($record) => [
                //     'wire:model.defer' => 'records.' . $record->getKey() . '.detalhe',
                //     'wire:change' => 'save(' . $record->getKey() . ')',
                // ]),
                Tables\Columns\TextInputColumn::make('detalhe')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->color('gray')->icon('heroicon-o-plus')->label('Adicionar Visitante'),

                Tables\Actions\AssociateAction::make()
                ->color('primary')
                ->icon('heroicon-o-plus-circle')
                ->label('Vincular Visitante')
                ->recordSelect(function () {

                    $visitantes = Visitante::leftJoin('membros','membros.id','visitantes.membro_convidou_id')
                    ->select(
                        'visitantes.id',
                        DB::raw('CONCAT(visitantes.nome, " - ", COALESCE(membros.nome, "Nenhum membro")) AS nome')
                    )
                    ->get()
                    ->pluck('nome', 'id')
                    ->toArray();

                    return Select::make('Nome do Visitante')
                    ->options($visitantes)->searchable(true);
                })
                ->action(fn ($arguments,$data,$form,$table) => $this->associateVisitante($data['Nome do Visitante'],$table->getLivewire()->ownerRecord->id)            ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make()
                ->action(fn ($record) => $this->dissociateVisitante($record->id,$record->culto_id)),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DissociateBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    protected function associateVisitante($visitanteId,$cultoId)
    {
        Participacao::firstOrCreate(['culto_id'=>$cultoId,'visitante_id'=>$visitanteId]);
    }
    protected function dissociateVisitante($visitanteId,$cultoId)
    {
        Participacao::where(['culto_id'=>$cultoId,'visitante_id'=>$visitanteId])->delete();
    }

}

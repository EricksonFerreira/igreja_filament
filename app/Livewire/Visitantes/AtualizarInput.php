<?php

namespace App\Livewire\Visitantes;

use App\Models\Participacao;
use Livewire\Component;

class AtualizarInput extends Component
{
    public $campo;
    public $id;
    public $valor;

    protected $listeners = ['atualizarInput'];

    public function atualizarInput($id, $valor)
    {
        $this->id = $id;
        $this->valor = $valor;
    }

    public function salvar()
    {
        $registro = Participacao::find($this->id);
        $registro->{$this->campo} = $this->valor;
        $registro->save();
    }

    public function render()
    {
        return view('livewire.visitantes.atualizar-input');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culto extends Model
{
    use HasFactory;
    protected $table= 'cultos';
    protected $fillable = [
        'inicio_evento',
        'fim_evento',
        'prev_inicio_evento',
        'prev_fim_evento',
        'evento_agendado',
        'evento_ocorreu',
        'tipo_culto_id'
    ];

    public function tipo_culto(){
        return $this->belongsTo(TiposCulto::class);
    }

    public function liturgia(){
        return $this->belongsTo(Liturgia::class);
    }

    public function membros(){
        return $this->belongsToMany(Membro::class,'participacoes_cultos', 'culto_id', 'membro_id')->withPivot('participou','entrei_contato','descricao');
    }

    public function visitantes(){
        return $this->belongsToMany(Visitante::class,'participacoes_cultos', 'culto_id', 'visitante_id')->withPivot('participou','entrei_contato','descricao');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membro extends Model
{
    use HasFactory;
    protected $table= 'membros';
    protected $fillable = ['nome','data_nasc','sexo','batizado','data_batismo','professou_fe','data_profissao_fe','status_membro_id','estado_civil_id' ];
    public function status_membro(){
        return $this->belongsTo(StatusMembro::class,'status_membro_id');
    }
    public function estado_civil(){
        return $this->belongsTo(EstadoCivil::class);
    }

    public function cultos(){
        return $this->belongsToMany(Culto::class,'participacoes_cultos','membro_id', 'culto_id')->withPivot('participou','entrei_contato','descricao');
    }
}

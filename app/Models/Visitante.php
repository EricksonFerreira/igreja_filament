<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;
    protected $table= 'visitantes';
    protected $fillable = [ 'nome','sexo','telefone','membro_convidou_id'];

    public function membro_convidou(){
        return $this->belongsTo(Membro::class);
    }
    public function cultos(){
        return $this->belongsToMany(Culto::class,'participacoes_cultos','visitante_id', 'culto_id')->withPivot('participou','entrei_contato','descricao');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participacao extends Model
{
    protected $table = 'participacoes_cultos'; // Nome da tabela

    protected $fillable = ['visitante_id','culto_id', 'membro_id', 'participou','entrei_contato','detalhe']; // Campos que podem ser preenchidos em massa

    // Relacionamento com o modelo Culto
    public function culto()
    {
        return $this->belongsTo(Culto::class, 'culto_id');
    }

    // Relacionamento com o modelo Membro
    public function membro()
    {
        return $this->belongsTo(Membro::class, 'membro_id');
    }
    // Relacionamento com o modelo Visitante
    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'visitante_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposCulto extends Model
{
    use HasFactory;
    protected $table = 'tipos_culto';
    protected $fillable = [
        'nome',
        'ativo'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liturgia extends Model
{
    use HasFactory;
    protected $table= 'liturgias';
    protected $fillable = [ 'arquivo' ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMembro extends Model
{
    use HasFactory;

    protected $table= 'status_membros';
    protected $fillable = [ 'nome' ];

}

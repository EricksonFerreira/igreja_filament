<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmprestaVeiculo extends Model
{
    use HasFactory;
    protected $table= 'empresta_veiculos';
    protected $fillable = [ 'data' ];

    protected $casts = [
        // 'data' => '',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mongodb\Laravel\Eloquent\Model;

class MovimentacaoConta extends Model
{
    use HasFactory;

    protected $fillable = [
        'origem',
        'conta',
        'nomeCorrentista',
        'docto',
        'cod',
        'descricao',
        'dr',
        'debito',
        'credito',
        'dataHora',
        'totalUA',
        'lctos',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mongodb\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MovimentacaoConta extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'movimentacao_contas';

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
        'data',
        'hora',
        'id',
        'lctos',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mongodb\Laravel\Eloquent\Model;

class MovimentacaoConta extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'movimentacao_contas';

    protected $fillable = [
        'coop',
        'agencia',
        'conta',
        'nomeCorrentista',
        'docto',
        'cod',
        'descricao',
        'dr',
        'debito',
        'credito',
        'dataHora',
        'id',
        'total UA/PAC',
        'lctos',
    ];
}

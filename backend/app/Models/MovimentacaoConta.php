<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoConta extends Model
{
    use HasFactory;

    protected $fillable = [
        'Origem',
        'Conta',
        'Nome Correntista',
        'Docto',
        'Cod',
        'Descricao',
        'DR',
        'Debito',
        'Total UA',
        'LCTOS',
        'Credito Id',
    ];
}

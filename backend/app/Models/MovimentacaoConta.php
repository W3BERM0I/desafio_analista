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

    public static function DataMaiorMenorQtdMov ()
    {
        $resultados = self::raw(function($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        'dataHora',
                        'total' => ['$sum' => 1],
                    ],
                ],
                [
                    '$sort' => ['total' => -1],
                ],
            ]);
        });

        // Acessar a data com a maior quantidade de movimentações
        $dataMaiorQuantidade = $resultados->first();

        // Acessar a data com a menor quantidade de movimentações
        $dataMenorQuantidade = $resultados->last();
        
        return [
            'data_maior_quantidade' => $dataMaiorQuantidade,
            'data_menor_quantidade' => $dataMenorQuantidade,
        ];
    }
}

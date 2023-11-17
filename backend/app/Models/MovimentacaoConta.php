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

    public static function DataMaiorMenorQtdMov ()
    {
        // $resultados = self::raw(function ($collection) {
        //     return $collection->aggregate([
        //         [
        //             '$group' => [
        //                 'data' => '$data',
        //                 'total' => ['$sum' => '$conta'],
        //             ],
        //         ]
        //     ]);
        // });

        // $resultados = self::raw()->aggregate(array(
        //     array(
        //         "$group" => array(
        //             "_id" => "$data",
        //             "total" => array("$count" => "$conta")
        //         )
        //     )   
        // ));

        $resultados = DB::collection('movimentacao_contas')->raw(function($collection) {
            return $collection->aggregate(array(
                array(
                    "$group" => array(
                        "data" => "$data",
                        "total" => array("$count" => "$conta")
                    )
                )   
            ));
        });



        info('res: ', $resultados);

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

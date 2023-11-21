<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentacaoConta;
use Illuminate\Support\Facades\DB;

class MetricsController extends Controller
{
    //Data com maior e menor quantidade de movimentações;
    public function DataMaiorMenorQtdMov()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$data',
                        'count' => ['$sum' => 1],
                    ],
                ],

        [
            '$sort' => [
                'count' => -1, // Use 1 for ascending order, -1 for descending order
            ],
        ],
            ]);
        });

        $data['maior'] = $resultados->first();

        // Acessar a data com a menor quantidade de movimentações
        $data['menor'] = $resultados->last();

        return response()->json([$data], 200);
    }

    //Data com maior e menor soma de movimentações;
    public function DataMaiorMenorSomaMov()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$data',
                        'somaMov' => ['$sum' => ['$add' => ['$debito', '$credito']]],
                    ],
                ],

        [
            '$sort' => [
                'somaMov' => -1, // Use 1 for ascending order, -1 for descending order
            ],
        ],
            ]);
        });

        $data['maior'] = $resultados->first();

        // Acessar a data com a menor quantidade de movimentações
        $data['menor'] = $resultados->last();

        return response()->json([$data], 200);
    }

    //Dia da semana em que houveram mais movimentações dos tipos (código de movimentação) “RX1” e “PX1”;
    public function movPixDiaSemana()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'cod' => ['$in' => ['RX1', 'PX1']], // Replace 'tes' with your specific description
                    ],
                ],
                [
                    '$addFields' => [
                        'formattedDate' => [
                            '$dateFromString' => [
                                'dateString' => '$data',
                                'format' => '%d/%m/%Y',
                            ],
                        ],
                    ],
                ],
                [
                    '$group' => [
                        '_id' => ['$dayOfWeek' => '$formattedDate'],
                        'count' => ['$sum' => 1],
                    ],
                ],
                [
                    '$sort' => [
                        '_id' => 1,
                    ],
                ],
            ]);
        });

        return response()->json([$resultados], 200);
    }

    //Quantidade e valor movimentado por coop/agência;
    public function qtdValorMovPorCoopAg()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$origem',
                        'somaMov' => ['$sum' => ['$add' => ['$debito', '$credito']]],
                    ],
                ],
                [
                    '$sort' => [
                        'somaMov' => -1,
                    ],
                ],
            ]);
        });
    
        return response()->json([$resultados], 200);
    }

    //Relação de créditos x débitos ao longo das horas do dia (valores fechados por hora. Ex: das 9h às 10h, das 10h às 11h, etc);  
    public function credVsDebPorHora()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$project' => [
                        'twoDigits' => ['$substr' => ['$hora', 0, 2]], // Ajuste 'yourColumn' para o nome real da sua coluna
                        'credito' => '$credito', // Ajuste para o nome real da sua coluna de crédito
                        'debito' => '$debito', // Ajuste para o nome real da sua coluna de débito
                    ],
                ],
                [
                    '$group' => [
                        '_id' => '$twoDigits',
                        'totalCredito' => ['$sum' => '$credito'],
                        'totalDebito' => ['$sum' => '$debito'],
                    ],
                ],
                [
                    '$sort' => [
                        '_id' => 1,
                    ],
                ],
            ]);
        });

        return response()->json([$resultados], 200);
        
    }
}

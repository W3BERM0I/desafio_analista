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
                        'count' => -1,
                    ],
                ],
            ]);
        });
        

        $data['maior'] = $resultados->first();
        $data['menor'] = $resultados->last();

        return response()->json([$data], 200);
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
                        'count' => ['$sum' => 1],
                    ],
                ],
                [
                    '$sort' => [
                        '_id' => 1, // Use 1 for ascending order, -1 for descending order
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
                    '$addFields' => [
                        'formattedTime' => [
                            '$dateFromString' => [
                                'dateString' => '$hora',
                                'format' => '%H:%M',
                            ],
                        ],
                    ],
                ],
                [
                    '$group' => [
                        '_id' => '$formattedTime',
                    ],
                ],
            ]);
        });
        

        // $data['maior'] = $resultados->first();
        // $data['menor'] = $resultados->last();

        return response()->json([$data], 200);
        
    }
}

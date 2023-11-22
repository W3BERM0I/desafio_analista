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
                        'somaMov' => 1, // Use 1 for ascending order, -1 for descending order
                    ],
                ],
            ]);
        });

        $data['menor'] = $resultados->first();
        
        $data['maior'] = $resultados->last();


        return response()->json([$data], 200);
    }

    //Dia da semana em que houveram mais movimentações dos tipos (código de movimentação) “RX1” e “PX1”;
    public function movPixDiaSemana()
    {
        $resultadosRx1 = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'cod' => ['$in' => ['RX1']], // Replace 'tes' with your specific description
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

        $resultadosPx1 = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'cod' => ['$in' => ['PX1']], // Replace 'tes' with your specific description
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

        $resultados = [];
        $resultados['px1'] = $resultadosPx1;
        $resultados['rx1'] = $resultadosRx1;

        return response()->json([$resultados], 200);
    }

    public function compararCodigosPorDiaDaSemana()
{
    $codigo1 = 'RX1';
    $codigo3 = 'PX1';

    $resultado = MovimentacaoConta::raw(function ($collection) use ($codigo1, $codigo3) {
        return $collection->aggregate([
            [
                '$match' => [
                    'cod' => ['$in' => [$codigo1, $codigo3]],
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
                    '_id' => [
                        'cod' => '$codigo',
                        'dayOfWeek' => '$formattedDate'
                    ],
                    'quantidade' => ['$sum' => 1],
                ],
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'codigo' => '$_id.cod',
                    'dia_da_semana' => '$_id.dayOfWeek',
                    'quantidade' => '$quantidade',
                ],
            ],
        ]);
    });

    // Organizar o resultado em um array associativo para facilitar o acesso
    $resultadosFinais = [];
    foreach ($resultado as $item) {
        $codigo = $item->codigo;
        $diaDaSemana = $item->dia_da_semana;
        $quantidade = $item->quantidade;

        // Criar array associativo com a contagem para cada código e dia da semana
        $resultadosFinais[$codigo][$diaDaSemana] = $quantidade;
    }

    return response()->json($resultado);
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
                        'quantidade' => ['$sum' => 1],

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

    //Quantidade e valor movimentado por coop/agência;
    public function qtdValorMovPorCoopAgprev()
    {
        $resultados = MovimentacaoConta::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$origem',
                        'somaMov' => ['$sum' => ['$add' => ['$debito', '$credito']]],
                        'quantidade' => ['$sum' => 1],

                    ],
                ],
                [
                    '$sort' => [
                        'somaMov' => -1,
                    ],
                ],
                [
                    '$limit' => 4,
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

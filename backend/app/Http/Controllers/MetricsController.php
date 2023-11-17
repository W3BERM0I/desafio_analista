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
        return response()->json([MovimentacaoConta::whereIn('cod', ['RX1', 'PX1'])->count()], 200);
    }

    //Quantidade e valor movimentado por coop/agência;
    public function qtdValorMovPorCoopAg()
    {
        return response()->json([MovimentacaoConta::whereIn('cod', ['RX1', 'PX1'])->count()], 200);
    }

    //Relação de créditos x débitos ao longo das horas do dia (valores fechados por hora. Ex: das 9h às 10h, das 10h às 11h, etc);  
    public function credVsDebPorHora()
    {
        return response()->json([MovimentacaoConta::whereIn('cod', ['RX1', 'PX1'])->count()], 200);
    }
}

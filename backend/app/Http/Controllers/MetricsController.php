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
        // $resultados = Movimentacao::select(DB::raw('DATE(data_movimentacao) as data'), DB::raw('COUNT(*) as total'))
        // ->groupBy('data_movimentacao')
        // ->orderBy('total', 'desc')
        // ->get();
    
        
        // $resultados = MovimentacaoConta::select(DB::raw('DATE(dataHora)'), DB::raw('COUNT(*) as total'))
        // ->groupBy('dataHora')
        // ->orderBy('total', 'desc')
        // ->get();

        // // Acessar a data com a maior quantidade de movimentações
        // $dataMaiorQuantidade = $resultados->first();
        
        // // Acessar a data com a menor quantidade de movimentações
        // $dataMenorQuantidade = $resultados->last();

        

        // return response()->json([MovimentacaoConta::whereIn('cod', ['RX1', 'PX1'])->count()], 200);
        return response()->json([MovimentacaoConta::DataMaiorMenorQtdMov()], 200);
    }

    //Data com maior e menor soma de movimentações;
    public function DataMaiorMenorSomaMov()
    {
        return response()->json([MovimentacaoConta::whereIn('cod', ['RX1', 'PX1'])->count()], 200);
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

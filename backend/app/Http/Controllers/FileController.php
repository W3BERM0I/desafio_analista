<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentacaoConta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return response()->json([...MovimentacaoConta::paginate()], 200);
    }


    public function store(Request $request)
    {
    if ($request->file('file')) {
        $arquivoPrn = $request->file('file');

        info('inicio');

        if ($arquivoPrn->isValid()) {
            // Leia o conteúdo do arquivo .PRN
            $conteudo = File::get($arquivoPrn);

            //quebrando o arquivo em linhas
            $linhas = explode("\n", $conteudo);

            //dados finais que serão armazenados no array
            $dados = [];
            //dados temporarios para coletar os dados do arquivo
            $dadosAux = [];

            //2 linhas
            $duasLinhas = false;
            //3 linhas
            $tresLinhas = false;

            $origem = '';

            foreach ($linhas as $linha) {


                if($duasLinhas) {
                    $dadosAux['dataHora'] = trim(substr($linha, 116, 16));
                    $dadosAux['id'] = $dadosAux['id'] ? $dadosAux['id'] : trim(substr($linha, 130, 2));

                    $dadosAux['debito'] = $dadosAux['debito'] ? $dadosAux['debito'] : trim(substr($linha, 99, 13));
                    
                    if($tresLinhas)
                        $dadosAux['dataHora'] = trim(substr($linha, 116, 16));

                    if(!preg_match("/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}$/", $dadosAux['dataHora'])){
                        $tresLinhas = !$tresLinhas;
                        continue;
                    }

                    $dados[] = [
                        'coop' => $dadosAux['coop'],
                        'agencia' => $dadosAux['agencia'],
                        'conta' => $dadosAux['conta'],
                        'nomeCorrentista' => $dadosAux['nomeCorrentista'],
                        'docto' => $dadosAux['docto'],
                        'cod' => $dadosAux['cod'],
                        'descricao' => $dadosAux['descricao'],
                        'dr' => $dadosAux['dr'],
                        'debito' => $dadosAux['debito'],
                        'credito' => $dadosAux['credito'],
                        'id' => $dadosAux['id'],
                        'dataHora' => $dadosAux['dataHora'],
                        'total UA/PAC' => $totalUa,
                        'lctos' => $lctos,
                    ];
                    $duasLinhas = !$duasLinhas;
                    $dadosAux = [];
                    continue;
                }

                $dadosAux['conta'] = trim(substr($linha, 8, 7));
                if(preg_match('/^\d{5}-\d$/', $dadosAux['conta'])) {

                    //verifica se a variavel o campo da origem esta vazio e se estiver vazio pega o valor do ultima campo preenchido
                    $origem = trim(substr($linha, 0, 7)) ? trim(substr($linha, 0, 7)) : $origem;

                    //verica se for um array ele esta pegando o valor de origem anterior
                    if(is_array($origem)) {
                        $dadosAux['coop'] = $origem[0];
                        $dadosAux['agencia'] = $origem[1];
                    } else {
                        // verifica se o campo de coop vem junto ou se esta sem (quando esta sem quer dizer que é da nossa coop: 0101)
                        if(strlen($origem) <= 3){
                            $dadosAux['coop'] = '0101';
                            $dadosAux['agencia'] = $origem;
                        } else {
                            $origem = explode('/', $origem);
                            $dadosAux['coop'] = $origem[0];
                            $dadosAux['agencia'] = $origem[1];
                        }
                    }

                    $dadosAux['nomeCorrentista'] = utf8_encode(trim(substr($linha, 16, 16)));
                    $dadosAux['docto'] = utf8_encode(trim(substr($linha, 48, 7)));
                    $dadosAux['cod'] = trim(substr($linha, 58, 3));
                    $dadosAux['descricao'] = trim(substr($linha, 62, 26));
                    $dadosAux['dr'] = trim(substr($linha, 88, 7));
                    $dadosAux['credito'] = trim(substr($linha, 110, 30));
                    $dadosAux['credito'] = (explode(" ", $dadosAux['credito']))[0];
                    $dadosAux['debito'] = trim(substr($linha, 99, 13));
                    $dadosAux['id'] = trim(substr($linha, 130, 2));
                    $duasLinhas = !$duasLinhas;
                } else {
                    $conta = '';
                    // continue;
                }



                $dr = '';

                if(true) {
                    $totalUa = '';
                    $lctos = utf8_encode(trim(substr($linha, 48, 8))); //esta incorreto
                    // $debito = trim(substr($linha, 104, 13));
                    // $credito = trim(substr($linha, 122, 14));
                    // $cod = trim(substr($linha, 58, 3));
                }
            }

            try {
                foreach (array_chunk($dados, 1000) as $chunk)
                MovimentacaoConta::insert($dados);
            }  catch(Exception $e) {
                info('error', [$e]);
            }

            info('fim');

            return "Arquivo .PRN convertido e salvo.";
        } else {
            return "Arquivo inválido.";
        }
    } else {
        return "Nenhum arquivo .PRN foi enviado.";
    }


        return response()->json(['uploaded' => true]);
    }
}

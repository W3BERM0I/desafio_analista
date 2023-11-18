<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentacaoConta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class FileController extends Controller
{
    public function index()
    {
        return response()->json([...MovimentacaoConta::where('lctos', "<>", 0)->get()], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'file' => 'required|file|max:2048', 
        ];

        $messages = [
            'file.required' => 'O campo de arquivo é obrigatório.',
            'file.file' => 'Nenhum arquivo .PRN foi enviado.',
        ];

        $request->validate($rules, $messages);

        $arquivoPrn = $request->file('file');

        // Leia o conteúdo do arquivo .PRN
        $conteudo = File::get($arquivoPrn);

        //quebrando o arquivo em linhas
        $linhas = explode("\n", $conteudo);

        //dados finais que serão armazenados no array
        $dados = [];

        //dados temporarios para coletar os dados do arquivo
        $dadosAux = [];

        //salva o ultimo dados aux quando começa um arquivo novo
        $ultimoDadosAux = [];
        $ultimaCoopAg = '';

        //2 linhas
        $duasLinhas = false;

        // verifica se ja começou a ler uma linha no final do ultimo arquivo
        if(Cache::has('duasLinhas')) {
            Cache::delete('duasLinhas');
            $duasLinhas = !$duasLinhas;
            $dadosAux = Cache::get('dadosAux');
        }

        // verifica se tem alguma coop/ag salva no cache do arquivo anterior
        if(Cache::has('coopAg'))
            $coopAg = Cache::get('coopAg');

        foreach ($linhas as $linha) {
            if($duasLinhas) {            
                $dadosAux['id'] = $dadosAux['id'] ? $dadosAux['id'] : trim(substr($linha, 130, 2));

                $dadosAux['debito'] = $dadosAux['debito'] ? $dadosAux['debito'] : $this->formamaStringDinheiro(trim(substr($linha, 99, 13)));

                $dataHora = trim(substr($linha, 116, 16));

                if(preg_match("/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}$/", $dataHora)) {
                    $dataHora = explode(' ', $dataHora);
                    $dadosAux['data'] = $dataHora[0];
                    $dadosAux['hora'] = $dataHora[1];
                    
                    $dados[] = [
                            'origem' => $dadosAux['origem'],
                            'conta' => $dadosAux['conta'],
                            'nomeCorrentista' => $dadosAux['nomeCorrentista'],
                            'docto' => $dadosAux['docto'],
                            'cod' => $dadosAux['cod'],
                            'descricao' => $dadosAux['descricao'],
                            'dr' => $dadosAux['dr'],
                            'debito' => $dadosAux['debito'],
                            'credito' => $dadosAux['credito'],
                            'id' => $dadosAux['id'],
                            'data' => $dadosAux['data'],
                            'hora' => $dadosAux['hora'],
                        ];
    
                    $duasLinhas = !$duasLinhas;
                            
                    $dadosAux = [];
                    continue;
                }

                continue;  
            }

            $dadosAux['conta'] = trim(substr($linha, 8, 7));


            if(preg_match('/^\d{5}-\d$/', $dadosAux['conta'])) {

               //verifica se a variavel o campo da origem esta vazio e se estiver vazio pega o valor do ultima campo preenchido
               $origem = trim(substr($linha, 0, 7));

               // verifica se tem uma nova coop/ag na transação atual se tenho que pegar da transacao passada
               if(!empty($origem)) {
                   // verifica se o campo de coop vem junto ou se esta sem (quando esta sem quer dizer que é da nossa coop: 0101)
                   if(strlen($origem) <= 3)
                       $coopAg = "0101/$origem";
                   else
                       $coopAg = $origem;

                    $ultimaCoopAg = $coopAg;
                }

                $dadosAux['origem'] = $coopAg;  
                $dadosAux['nomeCorrentista'] = utf8_encode(trim(substr($linha, 16, 16)));
                $dadosAux['docto'] = utf8_encode(trim(substr($linha, 48, 7)));
                $dadosAux['cod'] = trim(substr($linha, 58, 3));
                $dadosAux['descricao'] = trim(substr($linha, 62, 26));
                $dadosAux['dr'] = trim(substr($linha, 88, 7));
                $dadosAux['credito'] = $this->formamaStringDinheiro(trim(substr($linha, 110, 20)));
                $dadosAux['debito'] = $this->formamaStringDinheiro(trim(substr($linha, 99, 13)));
                $dadosAux['id'] = trim(substr($linha, 130, 2));

                $ultimoDadosAux = null;

                $ultimoDadosAux = $dadosAux;
                $duasLinhas = !$duasLinhas;
            }
        }

        if($duasLinhas) {
            Cache::put('dadosAux', $ultimoDadosAux, (5 * 60)); // 5 minutos
            Cache::put('duasLinhas', $duasLinhas, (5 * 60)); // 5 minutos
        }
        
        if($ultimaCoopAg) Cache::put('coopAg', $ultimaCoopAg, (5 * 60)); // 5 minutos

        try {
            foreach (array_chunk($dados, 1000) as $chunk)
                MovimentacaoConta::insert($chunk);
        }  catch(Exception $e) {
            info('error', [$e]);
        }

        return response()->json("Arquivo .PRN convertido e salvo.", 201);
    }

    protected function formamaStringDinheiro(string $value): float
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        $value = floatval($value);
        return $value;
    }
}

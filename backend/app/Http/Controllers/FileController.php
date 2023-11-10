<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MovimentacaoConta;
class FileController extends Controller
{
    public function store(Request $request)
    {
    //     $path = Storage::disk('local')->path("chunks/{$file->getClientOriginalName()}");

    //     File::append($path, $file->get());

    //     if ($request->has('is_last') && $request->boolean('is_last')) {
    //         $name = basename($path, '.part');

    //         File::move($path, "/path/to/public/someid/{$name}");
    //     }
    // if ($request->hasFile('imagem')) {
    if ($request->file('file')) {
        $arquivoPrn = $request->file('file');

        info('inicio');

        if ($arquivoPrn->isValid()) {
            // info('arquivo: ', [$arquivoPrn]);
            // Leia o conteúdo do arquivo .PRN
            $conteudo = File::get($arquivoPrn);


            // Agora, você precisa processar o conteúdo do arquivo .PRN para convertê-lo em um array associativo ou objeto
            // Aqui, usaremos um exemplo simples para demonstração. Adapte-o ao seu formato de arquivo .PRN
            $linhas = explode("\n", $conteudo);
            
            $dados = [];
            $flag = false;
            
            foreach ($linhas as $linha) {

                if($flag) {  
                    $dataHora = trim(substr($linha, 116, 16));
                    $dados[] = [
                        'origem' => $origem,
                        'conta' => $conta,
                        'nomeCorrentista' => $nomeCorrentista,
                        'docto' => $docto,
                        'cod' => $cod,
                        'descricao' => $descricao,
                        'dr' => $dr,
                        'debito' => $debito,
                        'totalUA' => $totalUa,
                        'lctos' => $lctos,
                        'dataHora' => $dataHora
                    ];
                    $flag = !$flag;
                }

                $origem = trim(substr($linha, 0, 7));
                if(!preg_match('/^\d{4}\/\d{2}$/' , $origem))
                    $origem = '';


                $conta = trim(substr($linha, 8, 7));
                if(preg_match('/^\d{5}-\d$/', $conta)) {
                    $nomeCorrentista = '';
                    // $nomeCorrentista = trim(substr($linha, 16, 16));
                    $final = strpos($linha, ' ', 48);
                    $docto = trim(substr($linha, 48, $final -48));
                    $cod = trim(substr($linha, 58, 3));
                    $descricao = trim(substr($linha, 62, 26));
                    $debito = trim(substr($linha, 104, 13));
                    $credito = trim(substr($linha, 122, 14));
                    $id = trim(substr($linha, 130, 2));
                    $flag = !$flag;
                } else {
                    $conta = '';
                    // continue;
                }



                // $dr = trim(substr($linha, 88, 7));
                $dr = '';

                if(false) {
                    $totalUa = '';
                    $lctos = trim(substr($linha, 48, 8));
                    $debito = trim(substr($linha, 104, 13));
                    $credito = trim(substr($linha, 116, 16));
                    $cod = trim(substr($linha, 58, 3));
                }
            }

            foreach (array_chunk($dados, 1000) as $chunk)
                MovimentacaoConta::insert($dados);

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

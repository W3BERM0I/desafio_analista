<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        info('request: ' . $request->name);

        // if ($request->hasFile('imagem')) {
        if (true) {
            $arquivoPrn = $request->file('imagem');

            if ($arquivoPrn->isValid()) {
                // Leia o conteúdo do arquivo .PRN
                $conteudo = File::get($arquivoPrn);

                // Agora, você precisa processar o conteúdo do arquivo .PRN para convertê-lo em um array associativo ou objeto
                // Aqui, usaremos um exemplo simples para demonstração. Adapte-o ao seu formato de arquivo .PRN
                $linhas = explode("\n", $conteudo);
                
                $dados = [];
                foreach ($linhas as $linha) {
                    $campos = explode("\t", $linha);
                    
                    info('json', [$campos]);
                    // Aqui, assumimos que a primeira coluna é a chave e a segunda coluna é o valor
                    if (count($campos) >= 2) {
                        $dados[$campos[0]] = $campos[1];
                    }
                }
                
                // Converta os dados em JSON
                $json = json_encode($dados, JSON_PRETTY_PRINT);

                // Salve o JSON em um arquivo ou retorne-o como resposta, dependendo das necessidades
                // Exemplo: salvar o JSON em um arquivo
                $caminhoDoJson = 'arquivo.json';
                Storage::disk('local')->put($caminhoDoJson, $json);

                return "Arquivo .PRN convertido para JSON e salvo em $caminhoDoJson.";
            } else {
                return "Arquivo inválido.";
            }
        } else {
            return "Nenhum arquivo .PRN foi enviado.";
        }

    return response()->json('cheguei');

    }
}

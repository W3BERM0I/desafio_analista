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
            $arquivoPrn = $request->file('file');

            if ($arquivoPrn->isValid()) {
                // Leia o conteúdo do arquivo .PRN
                $conteudo = File::get($arquivoPrn);

                // Agora, você precisa processar o conteúdo do arquivo .PRN para convertê-lo em um array associativo ou objeto
                // Aqui, usaremos um exemplo simples para demonstração. Adapte-o ao seu formato de arquivo .PRN
                $linhas = explode("\n", $conteudo);
                
                $dados = [];
                foreach ($linhas as $linha) {
                    info('linha: ', [$linha]);
                }
  

                return "Arquivo .PRN convertido e salvo.";
            } else {
                return "Arquivo inválido.";
            }
        } else {
            return "Nenhum arquivo .PRN foi enviado.";
        }

    return response()->json('cheguei');

    }

    public function store(Request $request)
    {
         $file = $request->file('file');
         info('file', [$file]);

    //     $path = Storage::disk('local')->path("chunks/{$file->getClientOriginalName()}");

    //     File::append($path, $file->get());

    //     if ($request->has('is_last') && $request->boolean('is_last')) {
    //         $name = basename($path, '.part');

    //         File::move($path, "/path/to/public/someid/{$name}");
    //     }

    info('request: ' . $request->name);

    // if ($request->hasFile('imagem')) {
    if (true) {
        $arquivoPrn = $request->file('file');

        if ($arquivoPrn->isValid()) {
            // Leia o conteúdo do arquivo .PRN
            $conteudo = File::get($arquivoPrn);

            // Agora, você precisa processar o conteúdo do arquivo .PRN para convertê-lo em um array associativo ou objeto
            // Aqui, usaremos um exemplo simples para demonstração. Adapte-o ao seu formato de arquivo .PRN
            $linhas = explode("\n", $conteudo);
            
            $dados = [];
            foreach ($linhas as $linha) {
                info('linha: ', [$linha]);
            }


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

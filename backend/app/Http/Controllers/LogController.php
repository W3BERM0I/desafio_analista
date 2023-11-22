<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log as LogModel;

//use App\Enums\Actions;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;



class LogController extends Controller
{
    /**
     * @param string $id     identification of the system you are accessing
     * @param string $data/hora     request time
     * @param string $ip            ip id
     * @param string $acao       identified action
     * @param string $descricao       description
     * @return void
     */

     public static function addsLog(string $id = null, string $acao, string $descricao = null):void
     {
        info('server: ', [$_SERVER]);
         try {
            LogModel::create([
                 'user_id' => $id,
                 'data/hora' => date('d/m/Y - H:i:s', $_SERVER['REQUEST_TIME']),
                 'ip' => $_SERVER['REMOTE_ADDR'],
                 'acao' => $acao, 
                 'descricao' => $descricao, 
             ]);
 
         } catch (Exception $err) {
             Log::error('Error adding log to database', [
                 'error' => $err
             ]);
         }
     }
}

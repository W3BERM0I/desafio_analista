<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('startEnd', function () {
    info('start/stop');
    return response()->json('cheguei', 200);
});

Route::post('login', [AuthController::class, 'login']);

Route::post('upload', [FileController::class, 'store'])->middleware('cors')->withoutMiddleware('throttle:api');
Route::get('index', [FileController::class, 'index']);

Route::get('DataMaiorMenorQtdMov', [MetricsController::class, 'DataMaiorMenorQtdMov']);
Route::get('DataMaiorMenorSomaMov', [MetricsController::class, 'DataMaiorMenorSomaMov']);
Route::get('movPixDiaSemana', [MetricsController::class, 'movPixDiaSemana']);
Route::get('qtdValorMovPorCoopAg', [MetricsController::class, 'qtdValorMovPorCoopAg']);
Route::get('credVsDebPorHora', [MetricsController::class, 'credVsDebPorHora']);


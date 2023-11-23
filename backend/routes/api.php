<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MetricsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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


Route::middleware('auth:sanctum')->group(function() {
    Route::get('uploadStart', [FileController::class, 'uploadStart']);
    Route::get('uploadEnd', [FileController::class, 'uploadEnd']);
    Route::post('upload', [FileController::class, 'store'])->middleware('cors')->withoutMiddleware('throttle:api');
    Route::get('DataMaiorMenorQtdMov', [MetricsController::class, 'DataMaiorMenorQtdMov']);
    Route::get('DataMaiorMenorSomaMov', [MetricsController::class, 'DataMaiorMenorSomaMov']);
    // Route::get('movPixDiaSemana', [MetricsController::class, 'compararCodigosPorDiaDaSemana']);
    Route::get('movPixDiaSemana', [MetricsController::class, 'movPixDiaSemana']);
    Route::get('qtdValorMovPorCoopAg', [MetricsController::class, 'qtdValorMovPorCoopAg']);
    Route::get('qtdValorMovPorCoopAgPrev', [MetricsController::class, 'qtdValorMovPorCoopAgPrev']);
    Route::get('credVsDebPorHora', [MetricsController::class, 'credVsDebPorHora']);

    Route::middleware(['admin'])->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('createUser', [AdminController::class, 'createUser']);
        Route::post('deleteUser', [AdminController::class, 'deleteUser']);
        Route::get('allCommonUser', [AdminController::class, 'allCommonUser']);
    });
});



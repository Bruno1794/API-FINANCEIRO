<?php

use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    ##ROTAS DE BANCOS
    Route::post('create-bank', [BankController::class, 'store']);
    Route::put('update-bank/{bank}', [BankController::class, 'update']);
    Route::get('show/{bank}', [BankController::class, 'show']);

});

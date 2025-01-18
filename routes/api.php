<?php

use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\DebitController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\URLController;
use \App\Http\Controllers\Api\ProviderController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('name');
Route::get('urls', [UrlController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    ##ROTAS DE BANCOS
    Route::post('create-bank', [BankController::class, 'store']);
    Route::put('update-bank/{bank}', [BankController::class, 'update']);
    Route::get('show/{bank}', [BankController::class, 'showId']);
    Route::get('banks', [BankController::class, 'show']);
    Route::delete('bank-delete/{bank}', [BankController::class, 'destroy']);

    ##ROTAS CARTAO CREDITO
    Route::get('show-cards',[CardController::class,'index']);
    Route::get('show-card/{card}',[CardController::class,'show']);
    Route::post('create-card',[CardController::class,'store']);
    Route::delete('delete-card/{card}',[CardController::class,'destroy']);
    Route::put('update-card/{card}',[CardController::class,'update']);

    ##Rotas Providers
    Route::get('providers',[ProviderController::class,'index']);
    Route::get('show-provider/{provider}',[ProviderController::class,'show']);
    Route::post('create-provider',[ProviderController::class,'store']);
    Route::put('update-provider/{provider}',[ProviderController::class,'update']);
    Route::delete('delete-provider/{provider}',[ProviderController::class,'destroy']);


    ##debit
    Route::get('debits',[DebitController::class,'index']);
    Route::get('debits-paid',[DebitController::class,'indexPaid']);
    Route::get('show-debit/{debit}',[DebitController::class,'show']);
    Route::put('quit-debit/{debit}',[DebitController::class,'updateQuit']);
    Route::delete('delete-debit/{debit}',[DebitController::class,'destroy']);
    Route::post('create-debit',[DebitController::class,'store']);
});

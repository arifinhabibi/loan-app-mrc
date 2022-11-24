<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReturnController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::POST('/login', [AuthController::class, 'login']);
Route::POST('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['user']], function() {
    Route::POST('/create-goods', [MainController::class, 'createGoods']);
    Route::GET('/delete-goods/{id}', [MainController::class, 'deleteGoods']);


    // list goods
    Route::GET('/list-goods', [MainController::class, 'listGoods']);

    // get all goods
    Route::Get('/loan', [LoanController::class, 'getAllGoods']);
    // create loan
    Route::post('/loan', [LoanController::class, 'loan']);

    // loan history
    Route::GET('/history', [LoanController::class, 'history']);

    // data loans
    Route::Get('/data-loans', [MainController::class, 'dataLoans']);

    // returning
    Route::Get('/return-goods/{id}', [ReturnController::class, 'returning']);
});
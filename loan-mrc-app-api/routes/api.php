<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MainController;

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



    // loans
    // get all goods
    Route::Get('/loan', [LoanController::class, 'getAllGoods']);
    // create loan
    Route::post('/loan', [LoanController::class, 'loan']);

});
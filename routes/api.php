<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShipController;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ship')->group(function(){
    Route::get('/',[ShipController::class,'index']);
    Route::post('/register',[ShipController::class, 'register']);
    Route::post('/approve',[ShipController::class, 'approve']);
    Route::get('/guest',[ShipController::class, 'getShip']);
});

Route::prefix('user')->group(function(){
    Route::post('/register',[UserController::class, 'register']);
    Route::post('/confirmOtp',[UserController::class, 'confirmOtp']);
    Route::post('/login',[UserController::class, 'login']);
    Route::post('/profile',[UserController::class, 'me']);
    Route::post('/approve',[UserController::class, 'approveUser']);
    Route::get('/guest',[UserController::class, 'guest']);
});

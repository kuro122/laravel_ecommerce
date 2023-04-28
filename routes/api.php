<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ormController;
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
// Route::middleware('auth:api')->group(function () {
    Route::get('/my-resource',[ApiController::class,'index']);
    Route::get('/my-resource/{id}',[ApiController::class,'show']);
    Route::post('/my-resource', [ApiController::class,'store']);
    Route::put('/my-resource/{id}', [ApiController::class,'update']);
    Route::delete('/my-resource/{id}',[ApiController::class,'destroy']);
    Route::get('ormtesting',[ormController::class,'ormtesting']);
// });

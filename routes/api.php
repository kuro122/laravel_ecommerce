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
   
    Route::get('ormtesting',[ormController::class,'ormtesting']);
    Route::post('addproducts',[ApiController::class,'addProductDetails']);
    Route::post('login',[ApiController::class,'login']);
    Route::get('getallproducts',[ApiController::class,'getallproducts']);
    Route::get('getallusers',[ApiController::class,'getallusers']);
    Route::get('search',[ApiController::class,'search']);
// });

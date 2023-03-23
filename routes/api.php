<?php

use App\Http\Controllers\ApiController;
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

Route::get('/',[ApiController::class,'index']);
Route::get('/adminlogin',[ApiController::class,'adminlogin']);
Route::post('/logins',[ApiController::class,'logins']);
Route::post('/adminsignup',[ApiController::class,'adminsignup']);
Route::get('/signupage',[ApiController::class,'signupage']);
Route::get('/addproducts',[ApiController::class,'addproducts']);
Route::post('/addproductdetails',[ApiController::class,'addproductdetails']);
Route::get('/shopdetails/{id}',[ApiController::class,'shopdetails']);

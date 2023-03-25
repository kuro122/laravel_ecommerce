<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\dataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[adminController::class,'index']);
Route::get('/adminlogin',[adminController::class,'adminlogin']);
Route::post('/logins',[adminController::class,'logins']);
Route::post('/adminsignup',[adminController::class,'adminsignup']);
Route::get('/signup',[adminController::class,'signupage']);
Route::get('/addproducts',[adminController::class,'addproducts']);
Route::post('/addproductdetails',[adminController::class,'addproductdetails']);
Route::get('/shopdetails/{id}',[adminController::class,'shopdetails']);
Route::get('/cart/{id}',[adminController::class,'cart']);
Route::get('/logout',[adminController::class,'logout']);
Route::get('/checkout/{id}',[adminController::class,'checkout']);
Route::get('/charge',[adminController::class,'striptest']);
//  for example and testing
Route::get('/striptest',[adminController::class,'striptest']);
Route::post('/placeorder',[adminController::class,'placeorder']);
Route::post('/checkoutdetails',[adminController::class,'checkoutdetails']);
Route::get('/destroy/{id}',[adminController::class,'destroy']);
Route::post('/pay',[adminController::class,'stripePost'])->name('stripe.post');
Route::get('/userlogin',[adminController::class,'userlogin']);
Route::post('/login_user',[adminController::class,'login_user']);
Route::get('/search', [adminController::class,'search']);
Route::get('/searcheddata', [adminController::class,'searcheddata']);
//  create coupon 
Route::get('/createnewcoupon',[adminController::class,'createnewcoupon']);
Route::post('/coupondetails',  [adminController::class,'coupondetails']);
Route::post('/checkcoupon',[adminController::class,'checkcoupon']);

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ data collector for admin +++++++++++
Route::get('/data',[dataController::class,'all_data']);

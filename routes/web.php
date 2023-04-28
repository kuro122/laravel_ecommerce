<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\productController;
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
// Route::post('/adminsignup',[adminController::class,'adminsignup']);
Route::get('/signup',[adminController::class,'signupage']);
Route::get('/adminlogin',[adminController::class,'adminlogin']);
Route::post('/logins',[adminController::class,'logins']);
Route::get('/userlogin',[adminController::class,'userlogin']);
Route::post('/login_user',[adminController::class,'login_user']);
Route::get('/logout',[adminController::class,'logout']);

Route::get('/addproducts',[adminController::class,'addproducts']);
Route::post('/addproductdetails',[adminController::class,'addproductdetails']);
Route::get('/shopdetails/{id}',[adminController::class,'shopdetails']);
Route::post('/cart/{id}',[adminController::class,'cart']);
Route::get('/checkout/{id}',[adminController::class,'checkout']);
Route::get('/charge',[adminController::class,'charge']);
//  for example and testing
Route::post('/checkoutdetails',[adminController::class,'checkoutdetails']);
Route::get('/destroy/{id}',[adminController::class,'destroy']);

Route::get('/searcheddata', [adminController::class,'searcheddata']);
//  create coupon 
Route::get('/createnewcoupon',[adminController::class,'createnewcoupon']);
Route::post('/coupondetails',  [adminController::class,'coupondetails']);
Route::post('/checkcoupon',[adminController::class,'checkcoupon']);
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ data collector for admin +++++++++++
Route::get('/data',[dataController::class,'srr']);
Route::get('/ajax_search',[adminController::class,'ajax_search']);
Route::get('/invoice',[adminController::class,'generatePDF']);
Route::get('/invoice_download',[adminController::class,'invoice_download']);
Route::post('/placeorder',[adminController::class,'placeorder']);
Route::get('/stripePost',[adminController::class,'stripePost']);
Route::get('/payment',[adminController::class,'payment']);
Route::post('/chargenow',[adminController::class,'chargenow']);
Route::get('/admin_index',[productController::class,'all_product']);
Route::get('/admin_product_delete/{id}',[productController::class,'product_delete']);
Route::post('/submit_review',[adminController::class,'review']);
Route::post('/rate',[adminController::class,'rate']);

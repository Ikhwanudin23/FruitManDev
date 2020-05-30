<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product','Api\Product\ProductController@index');
Route::post('product','Api\Product\ProductController@store');
Route::post('product/{id}/update','Api\Product\ProductController@update');
Route::get('product/{id}/delete','Api\Product\ProductController@delete');

Route::get('order','Api\Order\OrderController@index');
Route::get('order/{id}/confirmed','Api\Order\OrderController@confirmed');
Route::post('order/{id}/decline','Api\Order\OrderController@decline');
Route::post('order/store','Api\Order\OrderController@store');
Route::get('order/collector','Api\Order\OrderController@collector');
Route::get('order/seller','Api\Order\OrderController@seller');


Route::post('user/register', 'Api\User\Auth\RegisterController@register');
Route::post('user/login', 'Api\User\Auth\LoginController@login');





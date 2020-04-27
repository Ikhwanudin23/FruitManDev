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


Route::post('user/register', 'Api\User\Auth\RegisterController@register');
Route::post('user/login', 'Api\User\Auth\LoginController@login');





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
Route::post('product/store','Api\Product\ProductController@store');
Route::post('product/{id}/update','Api\Product\ProductController@update');
Route::get('product/{id}/delete','Api\Product\ProductController@delete');
Route::get('product/show','Api\Product\ProductController@show');

Route::get('order','Api\Order\OrderController@index');
Route::post('order/store','Api\Order\OrderController@store');
Route::post('order/{id}/decline','Api\Order\OrderController@decline');
Route::get('order/{id}/confirmed','Api\Order\OrderController@confirmed');
Route::get('order/{id}/completed', 'Api\Order\OrderController@completed');

Route::get('order/collector/waiting','Api\Order\OrderController@collectorWaiting');
Route::get('order/collector/inprogress','Api\Order\OrderController@collectorInProgress');
Route::get('order/collector/completed','Api\Order\OrderController@collectorCompleted');

Route::get('order/seller/orderin','Api\Order\OrderController@sellerOrderIn');
Route::get('order/seller/inprogress','Api\Order\OrderController@sellerInProgress');
Route::get('order/seller/completed','Api\Order\OrderController@sellerCompleted');

Route::post('user/register', 'Api\User\Auth\RegisterController@register');
Route::post('user/login', 'Api\User\Auth\LoginController@login');
Route::get('user/profile', 'Api\User\Profile\UserController@profile');
Route::post('user/profile/update', 'Api\User\profilee\UserController@updateprofile');
Route::get('email/verify/{id}', 'Api\User\Auth\VerificationController@verify')->name('api.verification.verify');
Route::get('email/resend', 'Api\User\Auth\VerificationController@resend')->name('api.verification.resend');
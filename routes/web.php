<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.getLogin');
});

//tag tampilan manual untuk melihat hasil templating
Route::get('/loginTemplate', function (){
    return view('loginTemplate');
});
Route::get('/userlist', function (){
    return view('pages/userlist');
});
Route::get('/dashboard', function (){
    return view('pages/dashboard');
});

Route::get('/UserList', function (){
    return view('pages/userlist');
});


Route::group(['prefix' => 'admin'], function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('index');
    Route::get('login', 'Admin\AuthController@getLogin')->name('admin.getLogin');
    Route::get('logout', 'Admin\AuthController@logout')->name('admin.logout');

    Route::post('login', 'Admin\AuthController@login')->name('admin.login');

/*    Route::resource('seller','SellerController');
    Route::resource('fruitCollectors','FruitCollectorsController');*/
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

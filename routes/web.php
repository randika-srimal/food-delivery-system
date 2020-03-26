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

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::get('privacy-policy', function () {
    return view('privacyPolicy');
});

Route::prefix('packs')->group(function () {
    Route::post('', 'PackController@addPack')->name('packs.add');
    Route::post('order', 'OrderController@addOrder')->name('packs.addOrder');
    Route::get('area', 'PackController@getPacksInArea')->name('packs.getPacksInArea');
    Route::post('{id}/delete', 'PackController@deletePack')->name('packs.delete');
});

Route::prefix('orders')->group(function () {
    Route::post('{id}/{status}', 'OrderController@changeStatus')->name('orders.changeStatus');
});

Route::prefix('users')->group(function () {
    Route::post('add', 'UserController@addUser')->name('users.add');
});

Route::get('auth/redirect/{provider}', 'SocialController@redirect');
Route::get('callback/{provider}', 'SocialController@callback');

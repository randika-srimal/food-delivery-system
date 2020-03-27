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

Route::get('/', 'WelcomeController@search')->name('search');

Route::get('/dashboard', 'WelcomeController@dashboard')->name('dashboard');

Route::get('privacy-policy', function () {
    return view('privacyPolicy');
});

Route::prefix('flyers')->group(function () {
    Route::get('', 'FlyersController@getFlyersInArea')->name('flyers.getFlyersInArea');
    Route::post('', 'FlyersController@addFlyer')->name('flyers.add');
    Route::post('upload', 'FlyersController@tryUpload')->name('flyers.tryUpload');
});

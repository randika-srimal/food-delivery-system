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

use Illuminate\Support\Facades\Auth;

Route::get('/', 'WelcomeController@search')->name('search');

Route::get('privacy-policy', function () {
    return view('privacyPolicy');
});

Route::prefix('flyers')->group(function () {
    Route::get('', 'FlyersController@getFlyersInArea')->name('flyers.getFlyersInArea');
    Route::post('', 'FlyersController@addFlyer')->name('flyers.add');
    Route::post('upload', 'FlyersController@tryUpload')->name('flyers.tryUpload');
    Route::post('{id}/delete', 'FlyersController@deleteFlyer')->name('flyers.tryDelete');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::match(['get', 'post'], 'login', function () {
    if (Auth::guest()) {
        return redirect('?action=openAddPackDialog');
    }
    return redirect('/');
});

Route::get('auth/redirect/{provider}', 'SocialController@redirect');
Route::get('callback/{provider}', 'SocialController@callback');

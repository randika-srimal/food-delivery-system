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

Route::prefix('offers')->group(function () {
    Route::get('', 'OffersController@getOffersInCity')->name('offers.getOffersInCity');
    Route::post('', 'OffersController@saveOffer')->name('offers.saveOffer');
    Route::post('upload', 'OffersController@saveOfferImage')->name('offers.saveOfferImage');
    Route::post('{id}/delete', 'OffersController@deleteOffer')->name('offers.deleteOffer');
});

Route::prefix('cities')->group(function () {
    Route::post('generate-share-image', 'CitiesController@generateShareImage')->name('cities.generateShareImage');
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

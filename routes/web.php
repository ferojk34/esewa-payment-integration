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

//  eSewa Pyament Gateway Routes
Route::get('checkout','WebsiteController@checkoutForm')->name('website.checkout');
Route::get('/success', 'EsewaController@success');
Route::get('/checkout/failure', 'EsewaController@failure');

// Pages
Route::get('success-page', function(){
    return view('website.success');
});

Route::get('fail-page', function(){
    return view('website.fail');
});


Route::get('/', function(){
    return view('welcome');
});
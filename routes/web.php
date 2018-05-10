<?php

//http://localhost:8000/offers/search?destination_name=&trip_date=2018-04-12&flexibility=3&length_of_stay=5


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
    return redirect('/offers');
});

Route::get('/offers', function () {
    return view('offers.home');
});

Route::get('/offers/search', 'OffersController@search')->name('offers.search');

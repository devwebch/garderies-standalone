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
$domain = parse_url(config('app.url'));

Route::domain('reseau.' . $domain['host'])->group(function () {
    Route::view('/', 'network.website');
});

Route::get('/', 'HomeController@index');
Route::get('/home2', 'HomeController@indexUser');
Route::view('blog', 'blog');
Route::view('account', 'account');

Route::resource('nurseries', 'NurseryController');
Route::get('nurseries/{nursery}/planning', 'NurseryController@planning')->name('nurseries.planning');
Route::get('nurseries/{nurseries}/ads', 'NurseryController@ads')->name('nurseries.ads');
Route::get('nurseries/{nurseries}/ads/create', 'AdController@create')->name('ads.create');
Route::resource('ads', 'AdController')->except(['index', 'create']);

Route::resource('users', 'UserController');
Route::get('users/{user}/availabilities', 'UserController@availabilities')->name('users.availabilities');
Route::get('users/{user}/bookings', 'UserController@bookings')->name('users.bookings');

Route::get('availabilities/search', 'AvailabilityController@search')->name('availabilities.search');
Route::resource('availabilities', 'AvailabilityController');

Route::resource('bookings', 'BookingController');
Route::resource('booking-requests', 'BookingRequestController');
Route::resource('networks', 'NetworkController');
Route::get('networks/{network}/ads', 'NetworkController@ads')->name('networks.ads');
Route::resource('feedbacks', 'FeedbackController');

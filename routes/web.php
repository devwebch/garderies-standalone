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

Route::get('/', 'HomeController@index');
Route::view('blog', 'blog');
Route::view('account', 'account');

Route::resource('nurseries', 'NurseryController');

Route::resource('users', 'UserController');
Route::get('users/{user}/availabilities', 'UserController@availabilities')->name('users.availabilities');
Route::get('users/{user}/bookings', 'UserController@bookings')->name('users.bookings');

Route::get('availabilities/search', 'AvailabilityController@search')->name('availabilities.search');
Route::resource('availabilities', 'AvailabilityController');

Route::resource('bookings', 'BookingController');
Route::resource('booking-requests', 'BookingRequestController');
Route::resource('networks', 'NetworkController');
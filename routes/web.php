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

Route::get('users/search', 'UserController@search')->name('users.search');
Route::resource('users', 'UserController');
Route::get('users/{user}/availabilities', 'UserController@availabilities')->name('users.availabilities');

Route::resource('availabilities', 'AvailabilityController');
Route::resource('bookings', 'BookingController');
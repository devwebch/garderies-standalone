<?php

use Illuminate\Http\Request;
use App\Http\Resources\Nursery;
use App\Http\Resources\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('nurseries', 'API\NurseryController');
Route::resource('users', 'API\UserController');
Route::resource('networks', 'API\NetworkController');
Route::resource('workgroups', 'API\WorkgroupController');

Route::get('availabilities/search', 'API\AvailabilityController@search');
Route::resource('availabilities', 'API\AvailabilityController');
Route::get('availabilities/user/{user}', 'API\AvailabilityController@showForUser')->name('availabilities.showforuser');

Route::resource('bookings', 'API\BookingController');
Route::get('bookings/user/{user}', 'API\BookingController@showForUser')->name('bookings.showforuser');
Route::post('bookings/approve/{booking}', 'API\BookingController@approve')->name('bookings.approve');

Route::resource('booking-requests', 'API\BookingRequestController');
Route::post('booking-requests/approve/{bookingRequest}', 'API\BookingRequestController@approve')->name('booking-requests.approve');

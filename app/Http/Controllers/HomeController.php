<?php

namespace App\Http\Controllers;

use App\Availability;
use App\Booking;
use App\BookingRequest;
use App\Charts\BookingsChart;
use App\Library\Services\TopList;
use App\Nursery;
use App\User;

class HomeController extends Controller
{
    public function index(TopList $topList)
    {
        $count_nursery  = Nursery::all()->count();
        $count_user     = User::select('users.*')
            ->join('network_user', 'users.id', '=', 'user_id')
            ->join('networks', 'networks.id', '=', 'network_id')->with('networks')
            ->join('nurseries', 'nurseries.id', '=', 'nursery_id')->with('nursery')
            ->where('users.id', '!=', 1)->count();
        $count_booking  = Booking::where('user_id', '!=', 1)->whereMonth('start', date('m'))->count();

        $bookingsChart = new BookingsChart();

        return view('home', [
            'count_nursery'         => $count_nursery,
            'count_user'            => $count_user,
            'count_booking'         => $count_booking,
            'chartBookings'         => $bookingsChart,
            'topList'               => $topList,
        ]);
    }

    public function indexUser()
    {
        $availabilities     = Availability::where('start', '>', now())
            ->take(5)
            ->get();
        $bookings           = Booking::where('start', '>', now())
            ->take(5)
            ->get();
        $bookingRequests    = BookingRequest::where('start', '>', now())
            ->take(5)
            ->get();

        return view('home-user', [
            'bookings'          => $bookings,
            'bookingRequests'   => $bookingRequests,
            'availabilities'    => $availabilities
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Charts\BookingsChart;
use App\Library\Services\TopList;
use App\Nursery;
use App\User;

class HomeController extends Controller
{
    public function index(TopList $topList)
    {
        $count_nursery  = Nursery::all()->count();
        $count_user     = User::all()->count();
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
}

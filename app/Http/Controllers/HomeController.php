<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Nursery;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $count_nursery  = Nursery::all()->count();
        $count_user     = User::all()->count();
        $count_booking  = Booking::all()->count();

        return view('home', [
            'count_nursery'     => $count_nursery,
            'count_user'        => $count_user,
            'count_booking'     => $count_booking,
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Rico
 * Date: 06/06/2018
 * Time: 14:24
 */

namespace App\Library\Services;
use App\User;

class TopList
{
    public function listOne()
    {
        $topUsers = User::withCount('bookings')->latest('bookings_count')->take(10)->with('bookings')->get();
        return view('chart.list', ['topUsers' => $topUsers]);
    }
}
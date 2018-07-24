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
    public function topReplacements($count = 10)
    {
        $topUsers = User::where('id', '!=', 1)->withCount('bookings')->latest('bookings_count')->take($count)->with('bookings')->get();
        return view('chart.list', ['topUsers' => $topUsers]);
    }
}
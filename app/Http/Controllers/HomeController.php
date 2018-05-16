<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Charts\HomeChart;
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

        $chart          = new HomeChart();
        $chart->options([
            'animation' => ['duration' => 0],
            'scales'     => [
                'xAxes' => [
                    'gridLines' => ['display' => false, 'color' => '#000000'],
                ]
            ]
        ]);

        $chart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai']);
        $chart->dataset('Remplacements', 'line', [100, 64, 84, 45, 90])
            ->options([
                'backgroundColor' => ['rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)']
            ]);

        return view('home', [
            'count_nursery'     => $count_nursery,
            'count_user'        => $count_user,
            'count_booking'     => $count_booking,
            'chart'             => $chart
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Charts\HomeChart;
use App\Nursery;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $count_nursery  = Nursery::all()->count();
        $count_user     = User::all()->count();
        $count_booking  = Booking::whereMonth('start', date('m'))->count();

        $monthly_bookings = DB::table('bookings')
            ->select(DB::raw("MONTH(start) as month"), DB::raw("COUNT(MONTH(start)) count"))
            ->groupBy('month')
            ->get();
        $monthly_bookings_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($monthly_bookings as $booking) {
            if ( ($booking->month - 1) < date('m')) {
                $monthly_bookings_dataset[$booking->month - 1] = $booking->count;
            }
        }

        $chart = new HomeChart();
        $chart->options([
            'animation' => ['duration' => 0],
            'elements' => [
                'point' => [
                    'radius' => 5,
                    'backgroundColor' => 'rgba(3,0,0,0.5)',
                    'borderWidth' => 3,
                ]
            ],
            'scales' => [
                'yAxes' => [
                    ['ticks' => [
                        'beginAtZero'   => true,
                        'max'           => 15
                    ]]
                ],
            ],

        ]);

        $chart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octore', 'Novembre', 'Décembre']);
        $chart->dataset('Remplacements mensuels', 'line', $monthly_bookings_dataset)
            ->options([
                'backgroundColor'       => '#33669959',
                'borderColor'           => '#33669995',
                'pointBackgroundColor'  => '#336699',
                'pointBorderColor'      => '#336699',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
            ]);

        return view('home', [
            'count_nursery'     => $count_nursery,
            'count_user'        => $count_user,
            'count_booking'     => $count_booking,
            'chart'             => $chart
        ]);
    }
}

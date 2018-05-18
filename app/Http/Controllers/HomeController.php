<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Charts\AvailabilitiesChart;
use App\Charts\BookingsChart;
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
        $chart_options = [
            'animation' => ['duration' => 0],
            'layout'    => [
                'padding' => [
                    'top'       => 10,
                    'right'     => 10,
                    'bottom'    => 10,
                    'left'      => 10
                ]
            ],
            'elements' => [
                'point' => [
                    'radius' => 5,
                    'hoverRadius' => 8,
                    'hitRadius' => 10,
                ]
            ],
            'scales' => [
                'yAxes' => [
                    ['ticks' => [
                        'beginAtZero'   => true
                    ]]
                ],
            ],

        ];
        $bookingsChart = new BookingsChart();
        $bookingsChart->options($chart_options);

        $bookingsChart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $bookingsChart->dataset('Remplacements mensuels', 'line', $monthly_bookings_dataset)
            ->options([
                'backgroundColor'       => '#33669959',
                'borderColor'           => '#33669995',
                'pointBackgroundColor'  => '#336699',
                'pointBorderColor'      => '#336699',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
                'lineTension'           => 0.3
            ]);


        $monthly_availabilities = DB::table('availabilities')
            ->select(DB::raw("MONTH(start) as month"), DB::raw("COUNT(MONTH(start)) count"))
            ->groupBy('month')
            ->get();
        $monthly_availabilities_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($monthly_availabilities as $availability) {
            if ( ($availability->month - 1) < date('m')) {
                $monthly_availabilities_dataset[$availability->month - 1] = $availability->count;
            }
        }

        $availabilitiesChart = new AvailabilitiesChart();
        $availabilitiesChart->options($chart_options);

        $availabilitiesChart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $availabilitiesChart->dataset('Disponibilités mensuelles', 'line', $monthly_availabilities_dataset)
            ->options([
                'backgroundColor'       => '#8bc34a59',
                'borderColor'           => '#8bc34a95',
                'pointBackgroundColor'  => '#8bc34a',
                'pointBorderColor'      => '#8bc34a',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
                'lineTension'           => 0.3
            ]);

        return view('home', [
            'count_nursery'         => $count_nursery,
            'count_user'            => $count_user,
            'count_booking'         => $count_booking,
            'chartBookings'         => $bookingsChart,
            'chartAvailabilities'   => $availabilitiesChart,
        ]);
    }
}

<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class BookingsChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $monthly_bookings = DB::table('bookings')
            ->select(DB::raw("MONTH(start) as month"), DB::raw("COUNT(MONTH(start)) count"))
            ->groupBy('month')
            ->get();
        $monthly_bookings_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($monthly_bookings as $booking) {
            if ( ($booking->month - 1) <= date('m')) {
                $monthly_bookings_dataset[$booking->month - 1] = $booking->count;
            }
        }

        $monthly_availabilities = DB::table('availabilities')
            ->select(DB::raw("MONTH(start) as month"), DB::raw("COUNT(MONTH(start)) count"))
            ->whereNotNull('deleted_at')
            ->groupBy('month')
            ->get();
        $monthly_availabilities_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($monthly_availabilities as $availability) {
            $monthly_availabilities_dataset[$availability->month - 1] = $availability->count;
        }

        $this->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);

        $this->dataset('Remplacements', 'line', $monthly_bookings_dataset)
            ->options([
                'backgroundColor'       => '#20aee390',
                'borderColor'           => '#20aee3',
                'pointBackgroundColor'  => '#20aee3',
                'pointBorderColor'      => '#20aee3',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
                'lineTension'           => 0.3
            ]);

        $this->dataset('Disponibilités', 'line', $monthly_availabilities_dataset)
            ->options([
                'backgroundColor'       => '#8bc34a59',
                'borderColor'           => '#8bc34a',
                'pointBackgroundColor'  => '#8bc34a',
                'pointBorderColor'      => '#8bc34a',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
                'lineTension'           => 0.3
            ]);

        $this->options([
            'animation' => ['duration' => 1000],
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
                    'radius' => 2,
                    'hoverRadius' => 5,
                    'hitRadius' => 10,
                ]
            ],
            'scales' => [
                'yAxes' => [
                    ['ticks' => [
                        'beginAtZero'   => true
                    ]]
                ],
            ]
        ]);
    }
}

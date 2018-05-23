<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class AvailabilitiesChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

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

        $this->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $this->dataset('Disponibilités', 'line', $monthly_availabilities_dataset)
            ->options([
                'backgroundColor'       => '#8bc34a59',
                'borderColor'           => '#8bc34a95',
                'pointBackgroundColor'  => '#8bc34a',
                'pointBorderColor'      => '#8bc34a',
                'pointStyle'            => 'circle',
                'borderWidth'           => 3,
                'lineTension'           => 0.3
            ]);

        $this->options([
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
            ]
        ]);
    }
}

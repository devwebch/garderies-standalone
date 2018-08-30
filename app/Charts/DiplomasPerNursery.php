<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class DiplomasPerNursery extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($nursery)
    {
        parent::__construct();

        $users = DB::table('users')
            ->join('diplomas', 'users.diploma_id', '=', 'diplomas.id')
            ->select(DB::raw("COUNT(users.id) count"))
            ->where('nursery_id', $nursery)
            ->groupBy('diploma_id')
            ->orderBy('diploma_id')
            ->get();

        $this->labels(['Auxiliaire', 'ASE', 'Educatrice ES']);

        $this->dataset('Diplomes', 'bar', $users->pluck('count'))
            ->options([
                'backgroundColor'       => ['#20aee3', '#4caf50', '#e81e63'],
                'borderWidth'           => 0,
                'lineTension'           => 0.3
            ]);

        $this->options([
            'animation' => ['duration' => 1000],
            'legend' => ['display' => false],
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
                    [
                        'ticks' => ['beginAtZero' => true, 'stepSize' => 1],
                        'gridLines' => ['color' => 'rgba(0, 0, 0, 0.05)']
                    ]
                ],
                'xAxes' => [
                    [
                        'gridLines' => ['color' => 'rgba(0, 0, 0, 0.0)']
                    ]
                ]
            ]
        ]);

    }
}

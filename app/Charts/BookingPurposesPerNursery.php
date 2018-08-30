<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class BookingPurposesPerNursery extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($nursery)
    {
        parent::__construct();

        $bookings = DB::table('bookings')
            ->join('purposes', 'bookings.purpose_id', '=', 'purposes.id')
            ->select(DB::raw("COUNT(bookings.id) count"), 'purpose_id')
            ->where('nursery_id', $nursery)
            ->whereYear('start', '2018')
            ->groupBy('purpose_id')
            ->orderBy('purpose_id')
            ->get();

        $this->labels(['Maladie', 'Vacances', 'Congé maternité', 'Service militaire / civil']);

        $dataset = [0, 0, 0, 0];

        foreach ($bookings as $booking) {
            $dataset[$booking->purpose_id - 1] = $booking->count;
        }

        $this->dataset('Absences', 'bar', $dataset)
            ->options([
                'backgroundColor' => ['#20aee3', '#4caf50', '#e81e63', '#607d8b'],
            ]);

        $this->options([
            'animation' => ['duration' => 1000],
            'legend'    => ['display' => false],
            'layout'    => [
                'padding' => [
                    'top'       => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0
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

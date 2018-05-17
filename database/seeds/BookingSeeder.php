<?php

use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users      = \App\User::all()->count();
        $nurseries  = \App\Nursery::all()->count();

        for($m = 1; $m <= 12; $m++) {

            for($i = 0; $i < rand(2, 12); $i++) {
                $day = $i;

                $start  = \Carbon\Carbon::create(date('Y'), $m)->addDay($day)->hour(rand(6, 11))->minute(0);
                $end    = \Carbon\Carbon::create(date('Y'), $m)->addDay($day)->hour(rand(12, 18))->minute(0);

                if ($start->isSaturday()) {
                    $start->addDay(2);
                    $end->addDay(2);
                    $i+=2;
                } elseif ($start->isSunday()) {
                    $start->addDay(1);
                    $end->addDay(1);
                    $i++;
                }

                DB::table('bookings')->insert([
                    'user_id'           => rand(1, $users),
                    'substitute_id'     => rand(1, $users),
                    'nursery_id'        => rand(1, $nurseries),
                    'start'             => $start,
                    'end'               => $end,
                    'created_at'        => \Carbon\Carbon::now()
                ]);
            }
        }
    }
}

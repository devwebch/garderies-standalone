<?php

use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all()->count();

        for($user_id = 1; $user_id <= $users; $user_id++) {

            for ($i = 0; $i <= 5; $i++) {
                $day = $i;

                $start = \Carbon\Carbon::tomorrow()->addDay($day)->hour(rand(6, 11));
                $end = \Carbon\Carbon::tomorrow()->addDay($day)->hour(rand(12, 18));

                if ($start->isSaturday()) {
                    $start->addDay(2);
                    $end->addDay(2);
                    $i += 2;
                } elseif ($start->isSunday()) {
                    $start->addDay(1);
                    $end->addDay(1);
                    $i++;
                }

                DB::table('availabilities')->insert([
                    'user_id'       => $user_id,
                    'start'         => $start,
                    'end'           => $end,
                    'created_at'    => \Carbon\Carbon::now()
                ]);
            }
        }
    }
}

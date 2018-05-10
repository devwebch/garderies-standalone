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
        for($i = 0; $i < 10; $i++) {

            $day = $i + rand(0, 4);

            $start  = \Carbon\Carbon::tomorrow()->addDay($day)->hour(rand(6, 11));
            $end    = \Carbon\Carbon::tomorrow()->addDay($day)->hour(rand(12, 18));

            DB::table('bookings')->insert([
                'user_id'           => 2,
                'substitute_id'     => 1,
                'nursery_id'        => 1,
                'start'             => $start,
                'end'               => $end,
                'created_at'        => \Carbon\Carbon::now()
            ]);
        }
    }
}

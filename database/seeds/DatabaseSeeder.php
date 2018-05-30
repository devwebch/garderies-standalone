<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(NurserySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AvailabilitySeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(NetworkSeeder::class);
    }
}

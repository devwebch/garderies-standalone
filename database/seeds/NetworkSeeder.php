<?php

use Illuminate\Database\Seeder;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('networks')->insert([
            'name'      => 'Ajerco',
            'owner_id'  => 1,
            'color'     => '#2196F3',
        ]);
        DB::table('networks')->insert([
            'name'      => 'Ajoval',
            'owner_id'  => 1,
            'color'     => '#8BC34A',
        ]);

        // Seeds the network_user table
        $users = \App\User::count();
        for ($i = 2; $i <= $users; $i++) {
            DB::table('network_user')->insert([
                'user_id'       => $i,
                'network_id'    => rand(1,2)
            ]);
        }
    }
}

<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {

    $diplomas = \App\Diploma::count();

    $first_name = $faker->firstName('female');
    $last_name  = $faker->lastName;

    return [
        'name'              => $first_name . ' ' . $last_name,
        'email'             => strtolower($first_name) . '.' . strtolower($last_name) . '@example.org',
        'phone'             => '+41 79 ' . rand(300, 500) . ' ' . rand(20, 90) . ' ' . rand(20, 90),
        'nursery_id'        => rand(1, 15),
        'diploma_id'        => rand(1, $diplomas),
        'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token'    => str_random(10),
    ];
});

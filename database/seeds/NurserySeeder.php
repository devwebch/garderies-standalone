<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Nursery;

class NurserySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $nurseries = [
            "Croquelune",
            "Croquesoleil",
            "Les Lucioles",
            "La Toupie",
            "La Chenoille",
            "Le Chap'rond rouge",
            "L'arlequin",
            "Les Moussaillons",
            "Les Funambules",
            "Croquétoile",
            "Les Laurelles",
            "Les Chavannes",
            "Les Lionceaux",
            "Les Frimousses",
            "L'atelier Magique",
            "Perlimpimpim",
            "L'Oasis",
            "Calimero",
            "Canailles",
            "Les Lucioles",
            "Petites couleurs",
            "L'oiseau Lyre",
            "L'Ondine",
            "Plein Soleil",
            "Les Petits Poucets",
            "L'Attique"
        ];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('nurseries')->insert([
                'name'          => $nurseries[$i],
                'slug'          => SlugService::createSlug(Nursery::class, 'slug', $nurseries[$i]),
                'created_at'    => \Carbon\Carbon::now(),
                'address'       => $faker->streetAddress,
                'post_code'     => rand(1000, 1500),
                'city'          => $faker->city,
                'email'         => $faker->companyEmail,
                'phone'         => '+41 ' . rand(21,22) . ' ' . rand(300, 500) . ' ' . rand(20, 90) . ' ' . rand(20, 90),
                'network_id'    => rand(1,2)
            ]);
        }
    }
}

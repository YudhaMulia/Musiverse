<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EraSeeder::class,
            LocationSeeder::class,
            CagarBudayaSeeder::class,
            AudioTourSeeder::class,
            KuisQuestionSeeder::class,
            KartuMatchSeeder::class,
            TebakGambarSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}

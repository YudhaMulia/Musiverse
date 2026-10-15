<?php

namespace Database\Seeders;

use App\Models\Era;
use Illuminate\Database\Seeder;

class EraSeeder extends Seeder
{
    public function run(): void
    {
        Era::create([
            'name' => 'Sriwijaya',
            'slug' => 'sriwijaya',
            'description' => 'Era Kerajaan Sriwijaya (abad VII - XIII)',
            'start_year' => 650,
            'end_year' => 1300,
            'color_code' => '#00a8e8',
        ]);

        Era::create([
            'name' => 'Kesultanan',
            'slug' => 'kesultanan',
            'description' => 'Era Kesultanan Palembang (abad XV - XVIII)',
            'start_year' => 1400,
            'end_year' => 1800,
            'color_code' => '#d62828',
        ]);

        Era::create([
            'name' => 'Kolonial',
            'slug' => 'kolonial',
            'description' => 'Era Penjajahan Belanda (abad XVIII - XX)',
            'start_year' => 1800,
            'end_year' => 1945,
            'color_code' => '#f77f00',
        ]);
    }
}

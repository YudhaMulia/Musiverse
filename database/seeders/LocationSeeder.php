<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::create([
            'name' => 'Menara Air Palembang',
            'latitude' => -2.9881,
            'longitude' => 104.7597,
            'address' => 'Jl. Merdeka No. 1',
            'district' => 'Musi Ulu',
            'postal_code' => '30129',
            'description' => 'Menara Air Palembang (Kantor Ledeng) dibangun tahun 1928',
        ]);

        Location::create([
            'name' => 'Benteng Kuto Besak',
            'latitude' => -2.9917,
            'longitude' => 104.7498,
            'address' => 'Jl. Sultan Mahmud Badaruddin II',
            'district' => 'Musi Ilir',
            'postal_code' => '30139',
            'description' => 'Benteng pertahanan megah dari era Kesultanan Palembang',
        ]);

        Location::create([
            'name' => 'Museum Sultan Mahmud Badaruddin II',
            'latitude' => -2.9850,
            'longitude' => 104.7456,
            'address' => 'Jl. Merdeka No. 16',
            'district' => 'Musi Ulu',
            'postal_code' => '30129',
            'description' => 'Bekas residen Belanda, kini museum budaya Palembang',
        ]);

        Location::create([
            'name' => 'Masjid Agung Palembang',
            'latitude' => -2.9892,
            'longitude' => 104.7634,
            'address' => 'Jl. Sudirman',
            'district' => 'Musi Ulu',
            'postal_code' => '30131',
            'description' => 'Masjid Agung Sultan Mahmud Badaruddin I (1738)',
        ]);

        Location::create([
            'name' => 'Bukit Siguntang',
            'latitude' => -2.9750,
            'longitude' => 104.7350,
            'address' => 'Jl. Diponegoro',
            'district' => 'Musi Ilir',
            'postal_code' => '30138',
            'description' => 'Bukit bersejarah tertinggi Palembang dari era Sriwijaya',
        ]);

        Location::create([
            'name' => 'Kampung Kapitan',
            'latitude' => -3.0050,
            'longitude' => 104.7680,
            'address' => 'Jl. Kapitan Mustofa',
            'district' => 'Musi Ilir',
            'postal_code' => '30144',
            'description' => 'Kampung tradisional bersejarah dengan arsitektur Arab-Melayu',
        ]);
    }
}

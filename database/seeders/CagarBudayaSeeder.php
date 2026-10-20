<?php

namespace Database\Seeders;

use App\Models\CagarBudaya;
use App\Models\Era;
use App\Models\Location;
use Illuminate\Database\Seeder;

class CagarBudayaSeeder extends Seeder
{
    public function run(): void
    {
        $sriwijaya = Era::where('slug', 'sriwijaya')->first();
        $kesultanan = Era::where('slug', 'kesultanan')->first();
        $kolonial = Era::where('slug', 'kolonial')->first();

        // Menara Air Palembang
        CagarBudaya::create([
            'name' => 'Menara Air Palembang',
            'slug' => 'menara-air-palembang',
            'era_id' => $kolonial->id,
            'location_id' => Location::where('name', 'Menara Air Palembang')->first()->id,
            'short_description' => 'Monumen hidrolik bersejarah dari era Hindia Belanda',
            'full_description' => 'Dibangun pada puncak transisi tata kota Hindia Belanda tahun 1928, menara air setinggi 35 meter ini berfungsi mendistribusikan air bersih Sungai Musi ke seluruh penjuru kota. Mengadopsi perpaduan gaya Art Deco fungsionalis Eropa dengan ketahanan fondasi rawa Palembang yang khas.',
            'registration_number' => 'CB-04/PLG/2018',
            'architect' => 'Ir. Thomas Karsten',
            'year_built' => 1928,
            'original_function' => 'Waterleiding (Penyaluran Air Bersih)',
            'current_function' => 'Kantor Walikota Palembang',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/menara-air-palembang.jpg',
            'ai_reconstruction_url' => null,
            'is_featured' => true,
        ]);

        // Benteng Kuto Besak
        CagarBudaya::create([
            'name' => 'Benteng Kuto Besak',
            'slug' => 'benteng-kuto-besak',
            'era_id' => $kesultanan->id,
            'location_id' => Location::where('name', 'Benteng Kuto Besak')->first()->id,
            'short_description' => 'Kraton pertahanan megah dari era Kesultanan Palembang',
            'full_description' => 'Benteng pertahanan megah Sultan Mahmud Badaruddin I berlapis batu bata putih perekat kapur sirih, menghadap langsung ke lajur Sungai Musi. Menjadi simbol kedaulatan Kesultanan Palembang di masa jayanya.',
            'registration_number' => 'CB-02/PLG/2018',
            'architect' => 'Sultan Mahmud Badaruddin I',
            'year_built' => 1780,
            'original_function' => 'Benteng Pertahanan Istana',
            'current_function' => 'Monumen Bersejarah & Wisata Budaya',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/benteng-kuto-besak.jpg',
            'ai_reconstruction_url' => null,
            'is_featured' => true,
        ]);

        // Museum Sultan Mahmud Badaruddin II
        CagarBudaya::create([
            'name' => 'Museum Sultan Mahmud Badaruddin II',
            'slug' => 'museum-smb-ii',
            'era_id' => $kolonial->id,
            'location_id' => Location::where('name', 'Museum Sultan Mahmud Badaruddin II')->first()->id,
            'short_description' => 'Museum budaya yang menyimpan ratusan artefak songket dan keris pusaka',
            'full_description' => 'Bekas residen Belanda yang didirikan di atas tapak Kraton Kuto Lamo, kini menyimpan ratusan artefak songket dan keris pusaka. Memiliki arsitektur Indische Empire yang memukau dengan tangga kayu berganda dan kolom neoklasik.',
            'registration_number' => 'CB-03/PLG/2018',
            'architect' => 'Pemerintah Hindia Belanda',
            'year_built' => 1823,
            'original_function' => 'Rumah Tinggal Residen Belanda',
            'current_function' => 'Museum Budaya',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/museum-smb-ii.jpeg',
            'ai_reconstruction_url' => null,
            'is_featured' => true,
        ]);

        // Masjid Agung Palembang
        CagarBudaya::create([
            'name' => 'Masjid Agung Palembang',
            'slug' => 'masjid-agung-palembang',
            'era_id' => $kesultanan->id,
            'location_id' => Location::where('name', 'Masjid Agung Palembang')->first()->id,
            'short_description' => 'Masjid bersejarah dari era Kesultanan dengan arsitektur Melayu klasik',
            'full_description' => 'Masjid Agung Sultan Mahmud Badaruddin I dibangun tahun 1738 dengan arsitektur Melayu klasik. Merupakan pusat keagamaan dan pusat kebudayaan Palembang selama berabad-abad.',
            'registration_number' => 'CB-05/PLG/2018',
            'year_built' => 1738,
            'original_function' => 'Masjid Agung Kesultanan',
            'current_function' => 'Masjid Aktif & Monumen Bersejarah',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/masjid-agung-palembang.png',
            'ai_reconstruction_url' => null,
            'is_featured' => false,
        ]);

        // Bukit Siguntang
        CagarBudaya::create([
            'name' => 'Bukit Siguntang',
            'slug' => 'bukit-siguntang',
            'era_id' => $sriwijaya->id,
            'location_id' => Location::where('name', 'Bukit Siguntang')->first()->id,
            'short_description' => 'Situs spiritual Sriwijaya dengan penemuan arca Buddha bersejarah',
            'full_description' => 'Titik tertinggi Palembang purba, persemayaman bangsawan Sriwijaya serta penemuan arca Buddha Amarawati setinggi 2.7 meter. Merupakan bukti nyata kehebatan peradaban Kerajaan Sriwijaya.',
            'registration_number' => 'CB-01/PLG/2018',
            'year_built' => 700,
            'original_function' => 'Situs Spiritual & Pemakaman Bangsawan Sriwijaya',
            'current_function' => 'Situs Arkeologi & Pariwisata Budaya',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/bukit-siguntang.jpg',
            'ai_reconstruction_url' => null,
            'is_featured' => true,
        ]);

        // Kampung Kapitan
        CagarBudaya::create([
            'name' => 'Kampung Kapitan',
            'slug' => 'kampung-kapitan',
            'era_id' => $kesultanan->id,
            'location_id' => Location::where('name', 'Kampung Kapitan')->first()->id,
            'short_description' => 'Kampung tradisional dengan arsitektur Arab-Melayu yang khas',
            'full_description' => 'Kampung tradisional di Musi Ulu yang masih mempertahankan arsitektur Arab-Melayu khas era Kesultanan. Terdapat masjid bersejarah Al-Munawar dan berbagai bangunan tradisional yang terawat.',
            'registration_number' => 'CB-06/PLG/2018',
            'year_built' => 1600,
            'original_function' => 'Pemukiman Etnis Arab-Palembang',
            'current_function' => 'Kampung Wisata Budaya',
            'status' => 'active',
            'image_url' => 'images/cagar-budaya/kampung-kapitan.jpg',
            'ai_reconstruction_url' => null,
            'is_featured' => false,
        ]);
    }
}

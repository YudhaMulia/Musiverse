<?php

namespace Database\Seeders;

use App\Models\AudioTour;
use App\Models\CagarBudaya;
use Illuminate\Database\Seeder;

class AudioTourSeeder extends Seeder
{
    public function run(): void
    {
        $menara = CagarBudaya::where('slug', 'menara-air-palembang')->first();
        $benteng = CagarBudaya::where('slug', 'benteng-kuto-besak')->first();
        $museum = CagarBudaya::where('slug', 'museum-smb-ii')->first();

        AudioTour::create([
            'cagar_budaya_id' => $menara->id,
            'title' => 'Hikayat Air Bersih Gemeente: Menara Air 1928',
            'narration' => 'Pada tahun 1928, arsitek Ir. Thomas Karsten merancang sebuah menara air megah setinggi 35 meter untuk mendistribusikan air bersih dari Sungai Musi ke seluruh kota Palembang. Bangunan ini menggabungkan gaya Art Deco Eropa dengan kekuatan struktur yang mampu bertahan di atas tanah rawa. Hingga kini, Menara Air Palembang tetap menjadi simbol modernisasi kesehatan masyarakat di era Hindia Belanda.',
            'duration_seconds' => 222,
            'narrator' => 'AI Heritage Lab POLSRI',
            'language' => 'id',
        ]);

        AudioTour::create([
            'cagar_budaya_id' => $benteng->id,
            'title' => 'Benteng Pertahanan Kesultanan: Kuto Besak',
            'narration' => 'Benteng Kuto Besak dibangun oleh Sultan Mahmud Badaruddin I pada tahun 1780 sebagai benteng pertahanan megah menghadap ke Sungai Musi. Struktur benteng berlapis batu bata putih perekat kapur sirih ini pernah menjadi barisan terdepan pertahanan Kesultanan Palembang dari serangan musuh. Desainnya yang kokoh dan strategis menjadikan Kuto Besak sebagai simbol kekuasaan dan kedaulatan Palembang di masa itu.',
            'duration_seconds' => 198,
            'narrator' => 'AI Heritage Lab POLSRI',
            'language' => 'id',
        ]);

        AudioTour::create([
            'cagar_budaya_id' => $museum->id,
            'title' => 'Warisan Indische: Museum Sultan Mahmud Badaruddin II',
            'narration' => 'Museum Sultan Mahmud Badaruddin II adalah bekas rumah tinggal Residen Belanda yang dibangun di atas tapak Kraton Kuto Lamo. Dengan arsitektur Indische yang elegan, museum ini memiliki tangga kayu berganda yang megah dan kolom-kolom neoklasik yang memukau. Kini, museum menyimpan ribuan artefak berharga termasuk songket, keris pusaka, dan berbagai karya seni tradisional Palembang yang menceritakan kisah kerajaan dan budaya nusantara.',
            'duration_seconds' => 216,
            'narrator' => 'AI Heritage Lab POLSRI',
            'language' => 'id',
        ]);
    }
}

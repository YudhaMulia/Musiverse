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
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAgRugzlAGjPrJl5cZwfs4evo6yVF_7tGU9dM1E_NyJZGHN2js_AWx_0MtkPNUUcav9QooTeCjwYqJ7HdxKtBm-6ImU0Hf-uPVBCPx3N2JZdCDLBT4CHnGszJ9PMxLfTuOVjgHsI7vvHPQ1jzr772CX9H4Ui4StTmMuy4odXlxNgCpFK_7U07iOH7HC48L0gG_zzpGNG5S8UTetZkDqN2ly6ojERPkMaVyv4PG_hc1cIJxm8zMU0LWC',
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
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAuaS5hXVxARqJrkHVKnzYuaKM_naP-OcvFaoRqJeuNnO_YBPcqGxyY20ha1heO5OqaAlKsZjf9zMVwc5UPkFfEuy6PD8efN7_3kwLNDnyvMsoHww6nFEhSVjgGFqJu82UkEB5u4xskIlMIEdmadU8xDTWN5gM9lAaP1sQZt_ih4kGop66EN_7alVtSwOjXI85yNPMMSqafNKVdbYlhlC1eI6FD1j9Z4pY48WH4_4o2q3nrNFlb4KbY',
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
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAizcjQ9vkbBxY3qs-44C4G4NC9mWDA4u_i1T12MFzBQdwhUwk0rgB0pZ__PTb3NxlE_SarLYDq8qr6R_daPejmeJCKusvBMHDXSLjHr7-bXuyAtz3tcH-l9GRE0dWf7VGqtKUjm5GDzLMAdaYMTW7SBlZfukAOwpmD3ws19SEQT6j1qVTVMSfzyyhrYyskC9j4nOHphYnVCSSr4v2h9p0pwUKHZCGVa-qy5gnTw5ElnujLDGjYc56W',
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
            'image_url' => null,
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
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDijGvZ4vcxUC3Cs2FzMIH5RGpD06rHpy_PQYwlwT6-44iox0sg3g0kZ8QcwA6JMIkeq2z2FiKS2-y47j6Z3MkcKH-k6nIuH_G56D1yQwEAonXTDOaWOg7pAwj8Ahj6pd0QROZpiHh6pSfvqTtwcvwpz88V7f6pzxaCDXeaYrbDSxFrd4JgiCmTMnBDHokpE3nCHeCxgmfLb3_tWgR2YIYAWWRCP7R42TCaC6QZns73QcjhyUVcuwhc',
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
            'image_url' => null,
            'ai_reconstruction_url' => null,
            'is_featured' => false,
        ]);
    }
}

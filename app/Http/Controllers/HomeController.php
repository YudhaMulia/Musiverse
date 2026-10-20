<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Era;

class HomeController extends Controller
{
    public function index()
    {
        // Get all sites with images for carousel (with dynamic content per slide)
        $carouselSites = CagarBudaya::where('image_url', '!=', null)
            ->with(['era', 'location'])
            ->limit(5)
            ->get()
            ->map(function ($site, $index) {
                return [
                    'site' => $site,
                    'hero_title' => $this->getHeroTitle($site, $index),
                    'hero_subtitle' => $this->getHeroSubtitle($site, $index),
                    'hero_description' => $this->getHeroDescription($site, $index),
                    'badge_text' => $this->getBadgeText($site, $index),
                ];
            });

        // Get featured sites for preview section
        $featuredSites = CagarBudaya::where('is_featured', true)
            ->with(['era', 'location'])
            ->limit(3)
            ->get();

        $totalSites = CagarBudaya::count();
        $totalEras = Era::count();

        $stats = [
            [
                'icon' => 'account_balance',
                'number' => $totalSites,
                'suffix' => '+',
                'label' => 'Situs Sejarah',
                'description' => 'Cagar budaya terdata',
            ],
            [
                'icon' => 'headphones',
                'number' => $totalSites,
                'suffix' => '+',
                'label' => 'Audio Tour',
                'description' => 'Narasi sejarah lokasi',
            ],
            [
                'icon' => 'sports_esports',
                'number' => 3,
                'suffix' => '',
                'label' => 'Mini Game Edukatif',
                'description' => 'Kuis, Puzzle & Match Card',
            ],
        ];

        return view('home.index', compact('carouselSites', 'featuredSites', 'stats'));
    }

    private function getHeroTitle($site, $index)
    {
        $titles = [
            0 => 'Menghidupkan Kembali Jejak Sejarah Palembang yang Terlupakan',
            1 => 'Benteng Kuto Besak: Simbol Kedaulatan Kesultanan Palembang',
            2 => 'Museum SMB II: Menyimpan Ratusan Artefak Pusaka Melayu',
            3 => 'Masjid Agung Palembang: Arsitektur Melayu Klasik yang Megah',
            4 => 'Bukit Siguntang: Situs Spiritual & Bukti Kejayaan Sriwijaya',
        ];

        return $titles[$index] ?? $titles[0];
    }

    private function getHeroSubtitle($site, $index)
    {
        $subtitles = [
            0 => 'Eksplorasi Cagar Budaya Palembang',
            1 => 'Warisan Kesultanan Palembang',
            2 => 'Warisan Kolonial & Museum Budaya',
            3 => 'Warisan Keagamaan Kesultanan',
            4 => 'Warisan Kerajaan Sriwijaya',
        ];

        return $subtitles[$index] ?? $subtitles[0];
    }

    private function getHeroDescription($site, $index)
    {
        $descriptions = [
            0 => 'Jelajahi cagar budaya terbengkalai Palembang dengan dokumentasi visual foto asli lokasi. Memahami nilai sejarah yang tersembunyi secara interaktif dan edukatif.',
            1 => 'Benteng pertahanan megah Sultan Mahmud Badaruddin I berlapis batu bata putih perekat kapur sirih, menghadap langsung ke lajur Sungai Musi. Menjadi simbol kedaulatan Kesultanan Palembang di masa jayanya.',
            2 => 'Bekas residen Belanda yang didirikan di atas tapak Kraton Kuto Lamo, kini menyimpan ratusan artefak songket dan keris pusaka. Memiliki arsitektur Indische Empire yang memukau.',
            3 => 'Masjid Agung Sultan Mahmud Badaruddin I dibangun tahun 1738 dengan arsitektur Melayu klasik. Merupakan pusat keagamaan dan pusat kebudayaan Palembang selama berabad-abad.',
            4 => 'Titik tertinggi Palembang purba, persemayaman bangsawan Sriwijaya serta penemuan arca Buddha Amarawati setinggi 2.7 meter. Bukti nyata kehebatan peradaban Kerajaan Sriwijaya.',
        ];

        return $descriptions[$index] ?? $descriptions[0];
    }

    private function getBadgeText($site, $index)
    {
        $badges = [
            0 => 'Eksplorasi Cagar Budaya Palembang',
            1 => 'Kesultanan Palembang • 1780',
            2 => 'Era Kolonial • 1823',
            3 => 'Kesultanan Palembang • 1738',
            4 => 'Kerajaan Sriwijaya • 700 M',
        ];

        return $badges[$index] ?? $badges[0];
    }
}

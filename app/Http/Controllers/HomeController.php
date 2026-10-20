<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Era;

class HomeController extends Controller
{
    public function index()
    {
        // Get all sites with images for carousel
        $carouselSites = CagarBudaya::where('image_url', '!=', null)
            ->with(['era', 'location'])
            ->limit(6)
            ->get();

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
}

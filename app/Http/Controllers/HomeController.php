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
                'label' => 'Situs Sejarah',
                'description' => 'Cagar budaya terdata',
            ],
            [
                'icon' => 'smart_toy',
                'number' => 1,
                'label' => 'AI Storyteller',
                'description' => 'Narasi bahasa awam',
            ],
            [
                'icon' => 'games',
                'number' => 1,
                'label' => 'Mini Game Edukasi',
                'description' => 'Match Card interaktif',
            ],
        ];

        return view('home.index', compact('carouselSites', 'featuredSites', 'stats'));
    }
}

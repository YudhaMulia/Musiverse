<?php

namespace App\Http\Controllers;

use App\Models\AudioTour;
use App\Models\CagarBudaya;

class LandingPageController extends Controller
{
    public function index()
    {
        $totalSites = CagarBudaya::count();
        $totalAudioTours = AudioTour::count();

        return view('landing', compact('totalSites', 'totalAudioTours'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Era;
use Illuminate\Http\Request;

class CagarBudayaController extends Controller
{
    public function index()
    {
        $cagarBudayas = CagarBudaya::with(['era', 'location'])->get();
        $eras = Era::all();

        return view('cagar-budaya.index', compact('cagarBudayas', 'eras'));
    }

    public function show($slug)
    {
        $cagarBudaya = CagarBudaya::where('slug', $slug)
            ->with(['era', 'location', 'audioTours', 'reviews.user', 'reviews.photos'])
            ->firstOrFail();

        // Increment view count
        $cagarBudaya->increment('view_count');

        // Get related sites (same era, nearby locations)
        $relatedSites = CagarBudaya::where('era_id', $cagarBudaya->era_id)
            ->where('id', '!=', $cagarBudaya->id)
            ->with(['era', 'location'])
            ->limit(3)
            ->get();

        // Get reviews sorted by newest first
        $reviews = $cagarBudaya->reviews()
            ->with(['user', 'photos'])
            ->latest()
            ->paginate(10);

        return view('cagar-budaya.show', compact('cagarBudaya', 'relatedSites', 'reviews'));
    }
}

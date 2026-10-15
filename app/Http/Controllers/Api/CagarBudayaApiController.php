<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CagarBudaya;
use App\Models\Era;
use Illuminate\Http\Request;

class CagarBudayaApiController extends Controller
{
    public function index()
    {
        return CagarBudaya::with(['era', 'location', 'audioTours'])->get();
    }

    public function filterByEra($eraSlug)
    {
        $era = Era::where('slug', $eraSlug)->firstOrFail();

        return $era->cagarBudayas()->with(['location', 'audioTours'])->get();
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = CagarBudaya::where('name', 'like', "%{$query}%")
            ->orWhere('short_description', 'like', "%{$query}%")
            ->with(['era', 'location'])
            ->get();

        return response()->json($results);
    }

    public function getNearby(Request $request)
    {
        $latitude = $request->get('lat');
        $longitude = $request->get('lng');
        $distance = $request->get('distance', 5); // Default 5km

        $sites = CagarBudaya::with(['location', 'era'])
            ->get()
            ->filter(function ($site) use ($latitude, $longitude, $distance) {
                $earthRadius = 6371; // km

                $latFrom = deg2rad($latitude);
                $latTo = deg2rad($site->location->latitude);
                $lonFrom = deg2rad($longitude);
                $lonTo = deg2rad($site->location->longitude);

                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;

                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

                return $earthRadius * $angle <= $distance;
            });

        return response()->json($sites->values());
    }
}

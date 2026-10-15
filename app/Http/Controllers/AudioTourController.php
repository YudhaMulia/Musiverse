<?php

namespace App\Http\Controllers;

use App\Models\AudioTour;
use App\Models\CagarBudaya;

class AudioTourController extends Controller
{
    public function show(CagarBudaya $cagarBudaya)
    {
        $audioTours = $cagarBudaya->audioTours()->get();

        return view('audio-tour.show', compact('cagarBudaya', 'audioTours'));
    }

    public function play($id)
    {
        $audioTour = AudioTour::findOrFail($id);

        return view('audio-tour.play', compact('audioTour'));
    }
}

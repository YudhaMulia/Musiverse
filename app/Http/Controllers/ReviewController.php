<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(CagarBudaya $cagarBudaya)
    {
        return view('review.create', compact('cagarBudaya'));
    }

    public function store(Request $request, CagarBudaya $cagarBudaya)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'cagar_budaya_id' => $cagarBudaya->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $review->photos()->create([
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('cagar-budaya.show', $cagarBudaya->slug)
            ->with('success', 'Review berhasil ditambahkan!');
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        return view('review.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $review->photos()->create([
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('cagar-budaya.show', $review->cagarBudaya->slug)
            ->with('success', 'Review berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $cagarBudayaSlug = $review->cagarBudaya->slug;

        foreach ($review->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $review->delete();

        return redirect()->route('cagar-budaya.show', $cagarBudayaSlug)
            ->with('success', 'Review berhasil dihapus!');
    }

    public function deletePhoto($photoId)
    {
        $photo = $review->photos()->findOrFail($photoId);
        $this->authorize('update', $photo->review);

        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus!');
    }
}


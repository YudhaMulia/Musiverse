<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\Review;
use App\Models\ReviewPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function create(CagarBudaya $cagarBudaya)
    {
        // Jika pengguna sudah pernah mengulas cagar budaya ini, arahkan ke edit
        $existingReview = Review::where('user_id', auth()->id())
            ->where('cagar_budaya_id', $cagarBudaya->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('review.edit', $existingReview)
                ->with('info', 'Anda sudah memberikan ulasan untuk tempat ini. Silakan perbarui ulasan Anda.');
        }

        return view('review.create', compact('cagarBudaya'));
    }

    public function store(Request $request, CagarBudaya $cagarBudaya)
    {
        // Cegah duplikasi ulasan dari pengguna yang sama
        $existingReview = Review::where('user_id', auth()->id())
            ->where('cagar_budaya_id', $cagarBudaya->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('review.edit', $existingReview)
                ->with('info', 'Anda sudah memiliki ulasan untuk tempat ini. Silakan perbarui ulasan Anda.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ], [
            'rating.required' => 'Silakan pilih rating bintang untuk ulasan Anda.',
            'content.required' => 'Tuliskan cerita atau pengalaman kunjungan Anda.',
            'content.min' => 'Isi ulasan minimal 10 karakter.',
            'content.max' => 'Isi ulasan maksimal 1000 karakter.',
            'photos.max' => 'Maksimal 5 foto per ulasan.',
            'photos.*.image' => 'File yang diunggah harus berupa gambar.',
            'photos.*.mimes' => 'Format foto yang didukung: JPG, JPEG, PNG, GIF, WEBP.',
            'photos.*.max' => 'Ukuran foto maksimal 3MB per file.',
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

        return redirect()->to(route('cagar-budaya.show', $cagarBudaya->slug).'#ulasan-pengunjung')
            ->with('success', 'Terima kasih! Ulasan Anda berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        Gate::authorize('update', $review);

        return view('review.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ], [
            'rating.required' => 'Silakan pilih rating bintang untuk ulasan Anda.',
            'content.required' => 'Tuliskan cerita atau pengalaman kunjungan Anda.',
            'content.min' => 'Isi ulasan minimal 10 karakter.',
            'content.max' => 'Isi ulasan maksimal 1000 karakter.',
            'photos.max' => 'Maksimal 5 foto baru.',
            'photos.*.image' => 'File yang diunggah harus berupa gambar.',
            'photos.*.mimes' => 'Format foto yang didukung: JPG, JPEG, PNG, GIF, WEBP.',
            'photos.*.max' => 'Ukuran foto maksimal 3MB per file.',
        ]);

        $currentPhotosCount = $review->photos()->count();
        $newPhotosCount = $request->hasFile('photos') ? count($request->file('photos')) : 0;

        if ($currentPhotosCount + $newPhotosCount > 5) {
            return back()->withInput()->withErrors([
                'photos' => "Total foto tidak boleh melebihi 5. Saat ini sudah ada {$currentPhotosCount} foto.",
            ]);
        }

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

        return redirect()->to(route('cagar-budaya.show', $review->cagarBudaya->slug).'#ulasan-pengunjung')
            ->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $cagarBudayaSlug = $review->cagarBudaya->slug;

        foreach ($review->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $review->delete();

        return redirect()->to(route('cagar-budaya.show', $cagarBudayaSlug).'#ulasan-pengunjung')
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    public function deletePhoto($photoId)
    {
        $photo = ReviewPhoto::findOrFail($photoId);
        Gate::authorize('update', $photo->review);

        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();

        return back()->with('success', 'Foto ulasan berhasil dihapus!');
    }
}

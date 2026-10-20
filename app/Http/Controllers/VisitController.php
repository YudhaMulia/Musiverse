<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisitController extends Controller
{
    private const DISK = 'foto';

    /** Simpan / perbarui pengalaman (cerita, bintang, foto). */
    public function store(Request $request, string $slug)
    {
        abort_unless(collect(config('heritage_map.sites'))->contains('slug', $slug), 404);

        $data = $request->validate([
            'story'    => ['nullable', 'string', 'max:2000'],
            'rating'   => ['nullable', 'integer', 'between:0,5'],
            'nearby'   => ['nullable', 'boolean'],
            'photos'   => ['nullable', 'array', 'max:3'],
            'photos.*' => ['string'],
        ]);

        $nearby = (bool) ($data['nearby'] ?? false);

        $visit = Visit::firstOrNew([
            'user_id'   => $request->user()->id,
            'site_slug' => $slug,
        ]);

        if (! $visit->exists) {
            $visit->visited_at = now();
            $visit->frame      = 'polaroid';
            $visit->stickers   = [];
        }

        $visit->fill([
            'story'  => trim($data['story'] ?? '') ?: null,
            'rating' => ($data['rating'] ?? 0) ?: null,
            'nearby' => $nearby,
            'points' => $nearby ? 15 : 10,
        ])->save();

        $this->syncPhotos($visit, $data['photos'] ?? [], $slug);

        return response()->json(['visit' => $visit->fresh('photos')->toMap()]);
    }

    /** Simpan hiasan jurnal (bingkai + stiker). */
    public function decor(Request $request, string $slug)
    {
        $data = $request->validate([
            'frame'         => ['required', 'in:polaroid,polos,bulat,tape'],
            'stickers'      => ['nullable', 'array', 'max:60'],
            'stickers.*.e'  => ['required', 'string', 'max:16'],
            'stickers.*.x'  => ['required', 'numeric'],
            'stickers.*.y'  => ['required', 'numeric'],
            'stickers.*.r'  => ['required', 'numeric'],
            'stickers.*.s'  => ['required', 'numeric'],
        ]);

        $visit = Visit::where('user_id', $request->user()->id)
            ->where('site_slug', $slug)
            ->firstOrFail();

        $visit->update([
            'frame'    => $data['frame'],
            'stickers' => $data['stickers'] ?? [],
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * $items berisi: URL foto lama (dipertahankan) atau data URL base64 (foto baru).
     * Foto lama yang tidak ada di daftar akan dihapus.
     */
    private function syncPhotos(Visit $visit, array $items, string $slug): void
    {
     /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk     = Storage::disk(self::DISK);
        $existing = $visit->photos()->get()->keyBy(fn ($p) => $disk->url($p->path));
        $keep     = [];
        $order    = 0;

        foreach ($items as $item) {
            if (isset($existing[$item])) {
                $photo = $existing[$item];
                $photo->update(['sort_order' => $order++]);
                $keep[] = $photo->id;
                continue;
            }

            $path = $this->storeDataUrl($item, $slug);
            if ($path) {
                $photo  = $visit->photos()->create(['path' => $path, 'sort_order' => $order++]);
                $keep[] = $photo->id;
            }
        }

        foreach ($existing as $photo) {
            if (! in_array($photo->id, $keep, true)) {
                $disk->delete($photo->path);
                $photo->delete();
            }
        }
    }

    private function storeDataUrl(string $dataUrl, string $slug): ?string
    {
        if (! preg_match('#^data:image/(jpeg|png|webp);base64,#', $dataUrl, $m)) {
            return null;
        }

        $binary = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);

        if ($binary === false || strlen($binary) > 3 * 1024 * 1024) {
            return null;
        }
        if (@getimagesizefromstring($binary) === false) {
            return null;
        }

        $ext  = $m[1] === 'jpeg' ? 'jpg' : $m[1];
        $path = "visits/{$slug}/" . Str::uuid() . ".{$ext}";

        Storage::disk(self::DISK)->put($path, $binary);

        return $path;
    }
}
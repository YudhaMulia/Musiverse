<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CagarBudaya;
use App\Models\Era;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CagarBudayaAdminController extends Controller
{
    public function index()
    {
        $cagarBudayas = CagarBudaya::with(['era', 'location'])->get();

        return view('admin.cagar-budaya.index', compact('cagarBudayas'));
    }

    public function edit(CagarBudaya $cagarBudaya)
    {
        $eras = Era::all();

        return view('admin.cagar-budaya.edit', compact('cagarBudaya', 'eras'));
    }

    public function updateImage(Request $request, CagarBudaya $cagarBudaya)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ], [
            'image.required' => 'Gambar harus dipilih',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        // Delete old image if exists
        if ($cagarBudaya->local_image_path && Storage::disk('public')->exists($cagarBudaya->local_image_path)) {
            Storage::disk('public')->delete($cagarBudaya->local_image_path);
        }

        // Store new image
        $file = $request->file('image');
        $filename = Str::slug($cagarBudaya->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('cagar-budaya', $filename, 'public');

        // Update model with local path
        $cagarBudaya->update([
            'local_image_path' => $path,
            'image_url' => Storage::url($path), // Generate public URL
        ]);

        return redirect()->route('admin.cagar-budaya.index')->with('success', 'Gambar berhasil diupload: ' . $cagarBudaya->name);
    }

    public function destroy(CagarBudaya $cagarBudaya)
    {
        if ($cagarBudaya->local_image_path && Storage::disk('public')->exists($cagarBudaya->local_image_path)) {
            Storage::disk('public')->delete($cagarBudaya->local_image_path);
        }

        $cagarBudaya->update([
            'local_image_path' => null,
            'image_url' => null,
        ]);

        return redirect()->route('admin.cagar-budaya.index')->with('success', 'Gambar berhasil dihapus');
    }
}

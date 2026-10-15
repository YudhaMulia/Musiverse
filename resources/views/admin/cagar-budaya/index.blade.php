@extends('layouts.app')

@section('title', 'Admin - Kelola Gambar Cagar Budaya')

@section('content')
<div class="flex flex-col w-full">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md">
        <!-- Header -->
        <div class="flex items-center justify-between mb-space-lg">
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Admin - Kelola Gambar Cagar Budaya</h1>
            <a href="{{ route('cagar-budaya.index') }}" class="px-4 py-2 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface hover:text-secondary border border-secondary/30 font-label-md text-label-md uppercase transition-colors">
                <span class="material-symbols-outlined text-[16px] inline mr-2">arrow_back</span>Kembali
            </a>
        </div>

        @if(session('success'))
        <div class="p-4 rounded-lg bg-green-900/30 border border-green-500/50 text-green-100 font-body-sm">
            ✓ {{ session('success') }}
        </div>
        @endif

        <!-- Heritage Sites Grid -->
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
            @forelse($cagarBudayas as $site)
            <div class="rounded-xl bg-surface-container p-space-md border border-secondary/25 flex flex-col gap-space-md">
                <!-- Current Image -->
                <div class="relative w-full h-44 rounded-lg overflow-hidden bg-surface-container-lowest border border-outline-variant/30">
                    @if($site->image_url)
                    <img class="w-full h-full object-cover" src="{{ $site->image_url }}" alt="{{ $site->name }}" />
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-surface-container-high">
                        <span class="material-symbols-outlined text-secondary text-[48px] opacity-50">image_not_supported</span>
                    </div>
                    @endif
                </div>

                <!-- Site Info -->
                <div class="flex flex-col gap-1">
                    <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">{{ $site->era->name }}</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $site->name }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                        {{ $site->location->address }}
                    </p>
                </div>

                <!-- Upload Form -->
                <form action="{{ route('admin.cagar-budaya.update-image', $site) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-space-sm">
                    @csrf
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-on-surface file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-container file:text-secondary hover:file:bg-[#540818] cursor-pointer" required />
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2 px-3 rounded-lg bg-gradient-to-r from-primary-container to-secondary-container text-secondary font-label-md text-label-md uppercase tracking-wider flex items-center justify-center gap-2 transition-all shadow-sm hover:shadow-md">
                            <span class="material-symbols-outlined text-[16px]">upload</span>
                            <span>Upload</span>
                        </button>
                        @if($site->local_image_path)
                        <button type="submit" form="deleteForm{{ $site->id }}" class="flex-1 py-2 px-3 rounded-lg bg-red-900/30 hover:bg-red-900/50 text-red-300 border border-red-500/30 font-label-md text-label-md uppercase tracking-wider flex items-center justify-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span>Hapus</span>
                        </button>
                        @endif
                    </div>
                    @error('image')
                    <p class="text-red-400 font-body-sm">{{ $message }}</p>
                    @enderror
                </form>

                <!-- Delete Form -->
                @if($site->local_image_path)
                <form id="deleteForm{{ $site->id }}" action="{{ route('admin.cagar-budaya.destroy-image', $site) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                @endif

                <!-- Status -->
                <div class="text-xs text-on-surface-variant border-t border-outline-variant/30 pt-2">
                    @if($site->local_image_path)
                    <p class="text-green-300">✓ Gambar lokal tersimpan</p>
                    <p class="text-on-surface-variant text-xs mt-1">File: {{ basename($site->local_image_path) }}</p>
                    @else
                    <p class="text-orange-300">⚠ Belum ada gambar</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center">
                <p class="font-body-md text-body-md text-on-surface-variant">Tidak ada cagar budaya</p>
            </div>
            @endforelse
        </div>

        <!-- Instructions -->
        <div class="mt-space-xl p-space-md rounded-xl bg-surface-container border border-secondary/25">
            <h3 class="font-title-lg text-title-lg text-on-surface mb-2">📝 Panduan Upload Gambar</h3>
            <ul class="font-body-sm text-body-sm text-on-surface-variant space-y-1 ml-4">
                <li>✓ Pilih gambar dari komputer Anda (JPEG, PNG, GIF)</li>
                <li>✓ Ukuran maksimal: 5MB</li>
                <li>✓ Gambar akan disimpan di folder lokal server</li>
                <li>✓ Gambar lama akan otomatis dihapus saat upload gambar baru</li>
                <li>✓ Gunakan foto asli dari lokasi cagar budaya</li>
            </ul>
        </div>
    </div>
</div>
@endsection

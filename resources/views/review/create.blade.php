@extends('layouts.app')

@section('title', 'Tambah Review - ' . $cagarBudaya->name)

@section('content')
<div class="flex flex-col w-full">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-on-surface-variant text-body-sm">
            <a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Home</a>
            <span>›</span>
            <a href="{{ route('cagar-budaya.index') }}" class="hover:text-secondary transition-colors">Cagar Budaya</a>
            <span>›</span>
            <a href="{{ route('cagar-budaya.show', $cagarBudaya->slug) }}" class="hover:text-secondary transition-colors">{{ $cagarBudaya->name }}</a>
            <span>›</span>
            <span class="text-secondary">Tambah Review</span>
        </div>

        <!-- Main Content -->
        <div class="w-full max-w-2xl mx-auto">
            <div class="bg-surface-container-low rounded-lg p-space-md border border-outline-variant/30">
                <div class="flex items-center gap-space-sm mb-space-md">
                    <span class="material-symbols-outlined text-secondary text-[24px]">rate_review</span>
                    <h1 class="font-headline-sm text-headline-sm text-on-surface">Bagikan Pengalaman Anda</h1>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-lg">Berbagi cerita dan foto dari kunjungan Anda ke {{ $cagarBudaya->name }}</p>

                <form action="{{ route('review.store', $cagarBudaya) }}" method="POST" enctype="multipart/form-data" class="space-y-space-md">
                    @csrf

                    <!-- Rating Section -->
                    <div class="flex flex-col gap-space-sm">
                        <label class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Rating <span class="text-error">*</span></label>
                        <div class="flex items-center gap-space-sm">
                            @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer/rating-{{ $i }}" required>
                            <label for="rating-{{ $i }}" class="cursor-pointer text-on-surface-variant hover:text-secondary transition-colors">
                                <span class="material-symbols-outlined text-[32px] peer-checked/rating-{{ $i }}:text-secondary peer-checked/rating-{{ $i }}:fill-1">star</span>
                            </label>
                            @endfor
                        </div>
                        @error('rating')
                        <p class="font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Review Content -->
                    <div class="flex flex-col gap-space-sm">
                        <label for="content" class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Cerita Anda <span class="text-error">*</span></label>
                        <textarea
                            id="content"
                            name="content"
                            rows="6"
                            placeholder="Ceritakan pengalaman Anda mengunjungi tempat ini. Apa yang membuat Anda terkesan? Bagaimana kondisinya saat ini?"
                            class="w-full px-space-md py-space-sm rounded-lg bg-surface-container border border-outline-variant/30 text-on-surface placeholder-on-surface-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/50 font-body-md text-body-md"
                            required
                            minlength="10"
                            maxlength="1000"
                        ></textarea>
                        <div class="flex justify-between">
                            <span class="font-label-md text-label-md text-on-surface-variant">Min 10 karakter</span>
                            <span class="font-label-md text-label-md text-on-surface-variant"><span id="char-count">0</span>/1000</span>
                        </div>
                        @error('content')
                        <p class="font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photo Upload -->
                    <div class="flex flex-col gap-space-sm">
                        <label class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Foto Anda (Maksimal 5 foto)</label>
                        <div class="border-2 border-dashed border-outline-variant/50 rounded-lg p-space-md hover:border-secondary/50 transition-colors cursor-pointer" id="photo-drop-zone">
                            <input type="file" id="photos" name="photos[]" multiple accept="image/*" class="hidden" />
                            <label for="photos" class="cursor-pointer flex flex-col items-center gap-space-sm">
                                <span class="material-symbols-outlined text-secondary text-[40px]">add_a_photo</span>
                                <div class="flex flex-col items-center gap-space-xs">
                                    <span class="font-label-md text-label-md text-on-surface">Klik atau drag foto di sini</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">JPG, PNG, GIF (Max 2MB per foto)</span>
                                </div>
                            </label>
                        </div>

                        <!-- Photo Preview -->
                        <div id="photo-preview" class="grid grid-cols-2 md:grid-cols-3 gap-space-sm"></div>
                        @error('photos')
                        <p class="font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                        <p class="font-label-md text-label-md text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-space-sm pt-space-md border-t border-outline-variant/30">
                        <a href="{{ route('cagar-budaya.show', $cagarBudaya->slug) }}" class="flex-1 py-3 px-4 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface border border-secondary/30 font-label-md text-label-md tracking-wider uppercase flex items-center justify-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="flex-1 py-3 px-4 rounded-lg bg-gradient-to-r from-primary-container via-[#540818] to-secondary-container text-secondary font-label-lg text-label-lg tracking-wider uppercase font-bold flex items-center justify-center gap-2 shadow-[0_0_20px_rgba(114,9,33,0.6)] hover:shadow-secondary/25 hover:scale-[1.01] transition-all border border-secondary/50">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            <span>Kirim Review</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photos');
    const photoDropZone = document.getElementById('photo-drop-zone');
    const photoPreview = document.getElementById('photo-preview');
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    let selectedFiles = new DataTransfer();

    // Update character count
    contentTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });

    // Handle file selection
    photoInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop
    photoDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoDropZone.classList.add('bg-surface-container-high', 'border-secondary');
    });

    photoDropZone.addEventListener('dragleave', () => {
        photoDropZone.classList.remove('bg-surface-container-high', 'border-secondary');
    });

    photoDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        photoDropZone.classList.remove('bg-surface-container-high', 'border-secondary');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        if (selectedFiles.items.length + files.length > 5) {
            alert('Maksimal 5 foto');
            return;
        }

        for (let file of files) {
            selectedFiles.items.add(file);
        }

        photoInput.files = selectedFiles.files;
        updatePreview();
    }

    function updatePreview() {
        photoPreview.innerHTML = '';

        for (let i = 0; i < selectedFiles.files.length; i++) {
            const file = selectedFiles.files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border border-outline-variant/30" />
                    <button type="button" class="absolute top-1 right-1 w-6 h-6 rounded-full bg-error flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" onclick="removePhoto(${i})">
                        <span class="material-symbols-outlined text-on-error text-[16px]">close</span>
                    </button>
                `;
                photoPreview.appendChild(div);
            };

            reader.readAsDataURL(file);
        }
    }
});

window.removePhoto = function(index) {
    const photoInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();

    for (let i = 0; i < photoInput.files.length; i++) {
        if (i !== index) {
            dataTransfer.items.add(photoInput.files[i]);
        }
    }

    photoInput.files = dataTransfer.files;
    document.getElementById('photo-preview').innerHTML = '';

    // Re-trigger preview update
    const event = new Event('change', { bubbles: true });
    photoInput.dispatchEvent(event);
};
</script>
@endsection

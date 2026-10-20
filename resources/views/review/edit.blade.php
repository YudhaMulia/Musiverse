@extends('layouts.app')

@section('title', 'Edit Ulasan - ' . $review->cagarBudaya->name)

@section('content')
<div class="flex flex-col w-full bg-surface min-h-[calc(100vh-160px)]">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-on-surface-variant text-body-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
            <span class="text-secondary">›</span>
            <a href="{{ route('cagar-budaya.index') }}" class="hover:text-primary transition-colors">Cagar Budaya</a>
            <span class="text-secondary">›</span>
            <a href="{{ route('cagar-budaya.show', $review->cagarBudaya->slug) }}" class="hover:text-primary transition-colors">{{ $review->cagarBudaya->name }}</a>
            <span class="text-secondary">›</span>
            <span class="text-primary font-bold">Edit Ulasan</span>
        </div>

        <!-- Form Card Container -->
        <div class="w-full bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-secondary/40 shadow-md flex flex-col gap-6">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4 pb-4 border-b border-secondary/25">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-primary text-secondary flex items-center justify-center border border-secondary/50 shadow-sm shrink-0">
                        <span class="material-symbols-outlined text-[28px]">edit_note</span>
                    </div>
                    <div>
                        <h1 class="font-headline-sm text-headline-sm text-primary font-bold">Perbarui Ulasan Anda</h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant">Ulasan untuk: <span class="font-bold text-primary">{{ $review->cagarBudaya->name }}</span></p>
                    </div>
                </div>

                @if($review->cagarBudaya->image_url)
                <img src="{{ $review->cagarBudaya->image_url }}" alt="{{ $review->cagarBudaya->name }}" class="w-14 h-14 rounded-lg object-cover border border-secondary/40 hidden sm:block shrink-0 shadow-sm" />
                @endif
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
            <div class="p-4 rounded-xl bg-green-500/10 border border-green-600/40 text-green-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-600 text-[22px]">check_circle</span>
                    <span class="font-body-md text-body-md font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

            <form action="{{ route('review.update', $review) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6" id="editReviewForm">
                @csrf
                @method('PUT')

                <!-- Rating Selector -->
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider flex items-center gap-1">
                        <span>Rating Kunjungan</span>
                        <span class="text-error">*</span>
                    </label>

                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', $review->rating) }}" required>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 rounded-xl bg-surface-container/40 border border-secondary/25">
                        <div class="flex items-center gap-1" id="starContainer">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="star-btn cursor-pointer p-1 text-secondary/30 hover:scale-110 transition-transform focus:outline-none" 
                                    data-rating="{{ $i }}" 
                                    title="{{ $i }} Bintang">
                                <span class="material-symbols-outlined text-[36px] transition-colors star-icon">star</span>
                            </button>
                            @endfor
                        </div>

                        <div class="flex items-center gap-2 border-t sm:border-t-0 sm:border-l border-secondary/25 pt-2 sm:pt-0 sm:pl-4">
                            <span id="ratingScoreText" class="font-headline-sm text-headline-sm font-black text-primary">{{ number_format($review->rating, 1) }}</span>
                            <span id="ratingLabelText" class="text-xs sm:text-sm font-semibold text-secondary-container px-2.5 py-1 rounded-md bg-secondary/15 border border-secondary/30">
                                Sangat Baik
                            </span>
                        </div>
                    </div>

                    @error('rating')
                    <p class="font-label-md text-label-md text-error flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        <span>{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <!-- Review Content -->
                <div class="flex flex-col gap-2">
                    <label for="content" class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider flex items-center gap-1">
                        <span>Cerita Pengalaman Anda</span>
                        <span class="text-error">*</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="6"
                        class="w-full px-4 py-3 rounded-xl bg-surface-container border border-secondary/35 text-primary placeholder-on-surface-variant/60 focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/30 font-body-md text-body-md transition-all resize-y"
                        required
                        minlength="10"
                        maxlength="1000"
                    >{{ old('content', $review->content) }}</textarea>

                    <div class="flex items-center justify-between text-xs font-medium">
                        <span class="text-on-surface-variant flex items-center gap-1" id="minCharHint">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            <span>Minimal 10 karakter</span>
                        </span>
                        <span class="text-on-surface-variant">
                            <span id="char-count" class="font-bold text-primary">{{ strlen(old('content', $review->content)) }}</span> / 1000
                        </span>
                    </div>

                    @error('content')
                    <p class="font-label-md text-label-md text-error flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        <span>{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <!-- Existing Photos Section -->
                @if($review->photos->count() > 0)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">
                            Foto Saat Ini ({{ $review->photos->count() }} / 5)
                        </label>
                        <span class="text-xs text-on-surface-variant">Klik tombol silang merah untuk menghapus foto</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach($review->photos as $photo)
                        <div class="relative group aspect-square rounded-xl overflow-hidden bg-surface-container border border-secondary/35 shadow-sm">
                            <img src="{{ Storage::url($photo->photo_path) }}" alt="Foto ulasan" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" 
                                        onclick="deleteExistingPhoto({{ $photo->id }})" 
                                        class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs flex items-center gap-1 shadow-lg cursor-pointer transition-transform hover:scale-105" 
                                        title="Hapus foto ini">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upload New Photos Section -->
                @php
                    $availableSlots = 5 - $review->photos->count();
                @endphp

                @if($availableSlots > 0)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">
                            Tambah Foto Baru (Tersisa {{ $availableSlots }} slot)
                        </label>
                        <span class="text-xs text-on-surface-variant font-medium">Max 3MB per foto</span>
                    </div>

                    <!-- Drop Zone -->
                    <div class="border-2 border-dashed border-secondary/40 rounded-xl p-6 hover:border-secondary transition-all cursor-pointer bg-surface-container/30 hover:bg-surface-container/60 text-center flex flex-col items-center justify-center gap-2 group" id="photoDropZone">
                        <input type="file" id="photosInput" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" class="hidden" />
                        <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">add_a_photo</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="font-label-md text-label-md font-bold text-primary">Klik untuk memilih foto baru atau seret foto ke sini</span>
                            <span class="text-xs text-on-surface-variant">Format didukung: JPG, PNG, WEBP, GIF</span>
                        </div>
                    </div>

                    <!-- Photo Previews Grid -->
                    <div id="photoPreviewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mt-2 hidden"></div>

                    @error('photos')
                    <p class="font-label-md text-label-md text-error flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        <span>{{ $message }}</span>
                    </p>
                    @enderror
                    @error('photos.*')
                    <p class="font-label-md text-label-md text-error flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        <span>{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                @else
                <div class="p-4 rounded-xl bg-surface-container/60 border border-secondary/25 text-xs text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[20px]">info</span>
                    <span>Anda telah mencapai batas maksimal 5 foto untuk ulasan ini. Hapus foto yang ada terlebih dahulu jika ingin mengunggah foto baru.</span>
                </div>
                @endif

                <!-- Buttons Bar -->
                <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-4 border-t border-secondary/25">
                    <a href="{{ route('cagar-budaya.show', $review->cagarBudaya->slug) }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-bold border border-secondary/40 font-label-md text-label-md tracking-wider uppercase flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="w-full sm:flex-1 py-3 px-6 rounded-xl bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg text-label-lg tracking-wider uppercase font-bold flex items-center justify-center gap-2 shadow-md hover:scale-[1.01] transition-all border border-secondary/50 cursor-pointer">
                        <span class="material-symbols-outlined text-secondary text-[20px]">save</span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

            <!-- Separate Hidden Delete Photo Form -->
            <form id="deletePhotoForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteExistingPhoto(photoId) {
    if (confirm('Apakah Anda yakin ingin menghapus foto ulasan ini?')) {
        const form = document.getElementById('deletePhotoForm');
        form.action = '{{ url("review/photo") }}/' + photoId;
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Star Rating Logic
    const starContainer = document.getElementById('starContainer');
    const starButtons = starContainer.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('ratingInput');
    const ratingScoreText = document.getElementById('ratingScoreText');
    const ratingLabelText = document.getElementById('ratingLabelText');

    const ratingDescriptions = {
        1: { label: 'Sangat Mengecewakan', score: '1.0' },
        2: { label: 'Kurang Memuaskan', score: '2.0' },
        3: { label: 'Cukup Baik', score: '3.0' },
        4: { label: 'Sangat Baik', score: '4.0' },
        5: { label: 'Luar Biasa / Sangat Direkomendasikan', score: '5.0' }
    };

    let currentRating = parseInt(ratingInput.value) || 5;

    function renderStars(rating) {
        starButtons.forEach(btn => {
            const starVal = parseInt(btn.dataset.rating);
            const icon = btn.querySelector('.star-icon');
            if (starVal <= rating) {
                btn.classList.remove('text-secondary/30');
                btn.classList.add('text-secondary');
                icon.classList.add('fill-1');
            } else {
                btn.classList.remove('text-secondary');
                btn.classList.add('text-secondary/30');
                icon.classList.remove('fill-1');
            }
        });

        if (ratingDescriptions[rating]) {
            ratingScoreText.textContent = ratingDescriptions[rating].score;
            ratingLabelText.textContent = ratingDescriptions[rating].label;
        }
    }

    renderStars(currentRating);

    starButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            const hoverVal = parseInt(this.dataset.rating);
            renderStars(hoverVal);
        });

        btn.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.rating);
            ratingInput.value = currentRating;
            renderStars(currentRating);
        });
    });

    starContainer.addEventListener('mouseleave', function() {
        renderStars(currentRating);
    });

    // Content character counter
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    const minCharHint = document.getElementById('minCharHint');

    function updateCharCount() {
        const len = textarea.value.length;
        charCount.textContent = len;
        if (len < 10) {
            charCount.classList.add('text-error');
            charCount.classList.remove('text-primary');
            minCharHint.classList.add('text-error');
        } else {
            charCount.classList.remove('text-error');
            charCount.classList.add('text-primary');
            minCharHint.classList.remove('text-error');
        }
    }

    textarea.addEventListener('input', updateCharCount);
    updateCharCount();

    // Photo Drop Zone & File Management
    const dropZone = document.getElementById('photoDropZone');
    const photosInput = document.getElementById('photosInput');
    const previewContainer = document.getElementById('photoPreviewContainer');
    const dataTransfer = new DataTransfer();
    const availableSlots = {{ $availableSlots }};

    if (dropZone && photosInput) {
        dropZone.addEventListener('click', () => photosInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-secondary', 'bg-secondary/10');
        });

        ['dragleave', 'dragend'].forEach(type => {
            dropZone.addEventListener(type, () => {
                dropZone.classList.remove('border-secondary', 'bg-secondary/10');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-secondary', 'bg-secondary/10');
            if (e.dataTransfer.files) {
                appendFiles(e.dataTransfer.files);
            }
        });

        photosInput.addEventListener('change', (e) => {
            if (e.target.files) {
                appendFiles(e.target.files);
            }
        });
    }

    function appendFiles(files) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
        
        for (let file of files) {
            if (dataTransfer.items.length >= availableSlots) {
                alert(`Maksimal ${availableSlots} foto baru dapat ditambahkan.`);
                break;
            }
            if (!allowedTypes.includes(file.type)) {
                alert(`File ${file.name} bukan format gambar yang didukung.`);
                continue;
            }
            if (file.size > 3 * 1024 * 1024) {
                alert(`File ${file.name} melebihi batas 3MB.`);
                continue;
            }
            dataTransfer.items.add(file);
        }

        photosInput.files = dataTransfer.files;
        renderPreviews();
    }

    function renderPreviews() {
        if (!previewContainer) return;
        previewContainer.innerHTML = '';
        const files = dataTransfer.files;

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        previewContainer.classList.remove('hidden');

        Array.from(files).forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'relative group aspect-square rounded-xl overflow-hidden bg-surface-container border border-secondary/35 shadow-sm';

            const img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            img.src = URL.createObjectURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute top-1.5 right-1.5 w-7 h-7 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-md cursor-pointer transition-transform hover:scale-110';
            removeBtn.title = 'Hapus Foto';
            removeBtn.innerHTML = '<span class="material-symbols-outlined text-[16px]">close</span>';

            removeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                removeFile(index);
            });

            card.appendChild(img);
            card.appendChild(removeBtn);
            previewContainer.appendChild(card);
        });
    }

    function removeFile(index) {
        const newDt = new DataTransfer();
        const files = dataTransfer.files;
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                newDt.items.add(files[i]);
            }
        }
        dataTransfer.items.clear();
        for (let file of newDt.files) {
            dataTransfer.items.add(file);
        }
        photosInput.files = dataTransfer.files;
        renderPreviews();
    }
});
</script>
@endpush
@endsection

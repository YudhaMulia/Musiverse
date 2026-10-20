@extends('layouts.app')

@section('title', 'Tulis Ulasan - ' . $cagarBudaya->name)

@section('content')
<div class="flex flex-col w-full bg-surface min-h-[calc(100vh-160px)]">
    <div class="w-full px-margin py-space-md flex flex-col gap-space-md max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-on-surface-variant text-body-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
            <span class="text-secondary">›</span>
            <a href="{{ route('cagar-budaya.index') }}" class="hover:text-primary transition-colors">Cagar Budaya</a>
            <span class="text-secondary">›</span>
            <a href="{{ route('cagar-budaya.show', $cagarBudaya->slug) }}" class="hover:text-primary transition-colors">{{ $cagarBudaya->name }}</a>
            <span class="text-secondary">›</span>
            <span class="text-primary font-bold">Tulis Ulasan</span>
        </div>

        <!-- Form Card Container -->
        <div class="w-full bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-secondary/40 shadow-md flex flex-col gap-6">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4 pb-4 border-b border-secondary/25">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-primary text-secondary flex items-center justify-center border border-secondary/50 shadow-sm shrink-0">
                        <span class="material-symbols-outlined text-[28px]">rate_review</span>
                    </div>
                    <div>
                        <h1 class="font-headline-sm text-headline-sm text-primary font-bold">Bagikan Pengalaman Anda</h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant">Ulasan untuk: <span class="font-bold text-primary">{{ $cagarBudaya->name }}</span></p>
                    </div>
                </div>

                @if($cagarBudaya->image_url)
                <img src="{{ $cagarBudaya->image_url }}" alt="{{ $cagarBudaya->name }}" class="w-14 h-14 rounded-lg object-cover border border-secondary/40 hidden sm:block shrink-0 shadow-sm" />
                @endif
            </div>

            <form action="{{ route('review.store', $cagarBudaya) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6" id="reviewForm">
                @csrf

                <!-- Rating Selector -->
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider flex items-center gap-1">
                        <span>Rating Kunjungan</span>
                        <span class="text-error">*</span>
                    </label>

                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}" required>

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
                            <span id="ratingScoreText" class="font-headline-sm text-headline-sm font-black text-primary">5.0</span>
                            <span id="ratingLabelText" class="text-xs sm:text-sm font-semibold text-secondary-container px-2.5 py-1 rounded-md bg-secondary/15 border border-secondary/30">
                                Luar Biasa / Sangat Direkomendasikan
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
                        placeholder="Ceritakan pengalaman Anda mengunjungi cagar budaya ini. Bagaimana suasananya, fasilitasnya, hal yang paling berkesan, atau tips bermanfaat bagi pengunjung lain..."
                        class="w-full px-4 py-3 rounded-xl bg-surface-container border border-secondary/35 text-primary placeholder-on-surface-variant/60 focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/30 font-body-md text-body-md transition-all resize-y"
                        required
                        minlength="10"
                        maxlength="1000"
                    >{{ old('content') }}</textarea>

                    <div class="flex items-center justify-between text-xs font-medium">
                        <span class="text-on-surface-variant flex items-center gap-1" id="minCharHint">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            <span>Minimal 10 karakter</span>
                        </span>
                        <span class="text-on-surface-variant">
                            <span id="char-count" class="font-bold text-primary">0</span> / 1000
                        </span>
                    </div>

                    @error('content')
                    <p class="font-label-md text-label-md text-error flex items-center gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        <span>{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <!-- Photo Upload Section -->
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">
                            Unggah Foto Kunjungan (Opsional)
                        </label>
                        <span class="text-xs text-on-surface-variant font-medium">Maksimal 5 foto • Max 3MB/foto</span>
                    </div>

                    <!-- Drop Zone -->
                    <div class="border-2 border-dashed border-secondary/40 rounded-xl p-6 hover:border-secondary transition-all cursor-pointer bg-surface-container/30 hover:bg-surface-container/60 text-center flex flex-col items-center justify-center gap-2 group" id="photoDropZone">
                        <input type="file" id="photosInput" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" class="hidden" />
                        <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">add_a_photo</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="font-label-md text-label-md font-bold text-primary">Klik untuk memilih foto atau seret foto ke sini</span>
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

                <!-- Buttons Bar -->
                <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-4 border-t border-secondary/25">
                    <a href="{{ route('cagar-budaya.show', $cagarBudaya->slug) }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-bold border border-secondary/40 font-label-md text-label-md tracking-wider uppercase flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="w-full sm:flex-1 py-3 px-6 rounded-xl bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-lg text-label-lg tracking-wider uppercase font-bold flex items-center justify-center gap-2 shadow-md hover:scale-[1.01] transition-all border border-secondary/50 cursor-pointer">
                        <span class="material-symbols-outlined text-secondary text-[20px]">send</span>
                        <span>Kirim Ulasan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
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

    function appendFiles(files) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
        
        for (let file of files) {
            if (dataTransfer.items.length >= 5) {
                alert('Maksimal 5 foto per ulasan.');
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

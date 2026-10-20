@php
    $allReviews = $cagarBudaya->reviews ?? collect();
    $totalReviewsCount = $allReviews->count();
    $avgRating = $totalReviewsCount > 0 ? round($allReviews->avg('rating'), 1) : 0;
    
    // Rating distribution
    $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($allReviews as $rev) {
        if (isset($distribution[$rev->rating])) {
            $distribution[$rev->rating]++;
        }
    }
    
    $userReview = auth()->check() ? $allReviews->firstWhere('user_id', auth()->id()) : null;
@endphp

<!-- Reviews Section -->
<div class="w-full mt-space-xl flex flex-col gap-space-md" id="ulasan-pengunjung">
    <!-- Flash Notifications -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-green-500/10 border border-green-600/40 text-green-800 flex items-center justify-between shadow-sm animate-fade-in">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-green-600 text-[24px]">check_circle</span>
            <span class="font-body-md text-body-md font-semibold">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>
    @endif

    @if(session('info'))
    <div class="p-4 rounded-xl bg-blue-500/10 border border-blue-600/40 text-blue-800 flex items-center justify-between shadow-sm animate-fade-in">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-blue-600 text-[24px]">info</span>
            <span class="font-body-md text-body-md font-semibold">{{ session('info') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>
    @endif

    <!-- Section Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-secondary/25">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[28px]">rate_review</span>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Ulasan Pengunjung</h2>
                    @if($totalReviewsCount > 0)
                    <span class="px-2.5 py-0.5 rounded-full bg-primary text-[#F9F6F0] font-label-md text-label-md font-bold shadow-sm">
                        {{ $totalReviewsCount }}
                    </span>
                    @endif
                </div>
                <p class="text-xs text-on-surface-variant font-medium">Pengalaman langsung dari pengunjung {{ $cagarBudaya->name }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @auth
                @if($userReview)
                <a href="{{ route('review.edit', $userReview) }}" class="px-space-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 shadow-sm font-bold border border-secondary/50 transition-all hover:scale-[1.02]">
                    <span class="material-symbols-outlined text-secondary text-[18px]">edit_note</span>
                    <span>Edit Ulasan Saya</span>
                </a>
                @else
                <a href="{{ route('review.create', $cagarBudaya) }}" class="px-space-md py-2.5 rounded-lg bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 hover:scale-105 transition-all shadow-sm font-bold border border-secondary/50">
                    <span class="material-symbols-outlined text-secondary text-[18px]">add_comment</span>
                    <span>Tulis Ulasan</span>
                </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-space-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 border border-secondary/40 font-bold transition-all">
                    <span class="material-symbols-outlined text-secondary text-[18px]">login</span>
                    <span>Login untuk Ulasan</span>
                </a>
            @endauth
        </div>
    </div>

    @if($totalReviewsCount > 0)
    <!-- Rating Summary Dashboard Card -->
    <div class="w-full rounded-2xl bg-surface-container-lowest p-5 sm:p-6 border border-secondary/35 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <!-- Left Score Column -->
            <div class="md:col-span-4 flex flex-col items-center justify-center text-center p-4 bg-surface-container/40 rounded-xl border border-secondary/20">
                <span class="font-headline-lg text-headline-lg font-black text-primary text-5xl tracking-tight leading-none">
                    {{ number_format($avgRating, 1) }}
                </span>
                <div class="flex items-center gap-1 my-2">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[24px] {{ $i <= round($avgRating) ? 'text-secondary fill-1' : 'text-secondary/30' }}">star</span>
                    @endfor
                </div>
                <span class="text-sm font-medium text-on-surface-variant">
                    Berdasarkan <strong>{{ $totalReviewsCount }}</strong> ulasan pengunjung
                </span>
            </div>

            <!-- Right Distribution Progress Bars Column -->
            <div class="md:col-span-8 flex flex-col gap-2.5">
                @for($star = 5; $star >= 1; $star--)
                @php
                    $count = $distribution[$star] ?? 0;
                    $pct = $totalReviewsCount > 0 ? round(($count / $totalReviewsCount) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3 text-xs sm:text-sm">
                    <div class="flex items-center gap-1 w-14 shrink-0 font-bold text-primary">
                        <span>{{ $star }}</span>
                        <span class="material-symbols-outlined text-[16px] text-secondary fill-1">star</span>
                    </div>
                    <div class="flex-1 bg-surface-container-high h-2.5 rounded-full overflow-hidden border border-secondary/20">
                        <div class="bg-secondary h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%;"></div>
                    </div>
                    <div class="w-16 text-right font-medium text-on-surface-variant shrink-0">
                        <span>{{ $pct }}%</span>
                        <span class="text-xs text-on-surface-variant/60">({{ $count }})</span>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Review Items List -->
    <div class="space-y-space-md">
        @foreach($reviews as $review)
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-secondary/35 hover:border-secondary shadow-sm transition-all flex flex-col gap-space-sm" id="review-{{ $review->id }}">
            <!-- Review Header -->
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    @if($review->user->avatar_url)
                    <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="w-11 h-11 rounded-full object-cover border-2 border-secondary/50 shadow-sm" />
                    @else
                    <div class="w-11 h-11 rounded-full bg-primary flex items-center justify-center text-[#F9F6F0] font-label-lg text-label-lg font-bold border-2 border-secondary/40 shadow-sm shrink-0">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    @endif

                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-body-md text-body-md text-primary font-bold">{{ $review->user->name }}</span>
                            @if(auth()->check() && auth()->id() === $review->user_id)
                            <span class="px-2 py-0.5 rounded-full bg-secondary/15 text-primary border border-secondary/40 text-[11px] font-bold">
                                Ulasan Anda
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                            <span>{{ $review->created_at->diffForHumans() }}</span>
                            @if($review->updated_at->gt($review->created_at))
                            <span>•</span>
                            <span class="italic text-on-surface-variant/75">(Diedit)</span>
                            @endif
                        </div>
                    </div>
                </div>

                @can('update', $review)
                <div class="flex items-center gap-1">
                    <a href="{{ route('review.edit', $review) }}" class="p-2 rounded-lg hover:bg-surface-container text-primary transition-colors flex items-center gap-1 font-semibold text-xs" title="Edit Ulasan">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        <span class="hidden sm:inline">Edit</span>
                    </a>
                    <form action="{{ route('review.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-red-600 transition-colors flex items-center gap-1 font-semibold text-xs" title="Hapus Ulasan">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            <span class="hidden sm:inline">Hapus</span>
                        </button>
                    </form>
                </div>
                @endcan
            </div>

            <!-- Rating Stars -->
            <div class="flex items-center gap-1">
                @for($i = 1; $i <= 5; $i++)
                <span class="material-symbols-outlined text-[20px] {{ $i <= $review->rating ? 'text-secondary fill-1' : 'text-secondary/25' }}">star</span>
                @endfor
                <span class="font-label-md text-label-md text-primary font-bold ml-1.5">{{ number_format($review->rating, 1) }} / 5.0</span>
            </div>

            <!-- Review Content -->
            <p class="font-body-md text-body-md text-on-surface leading-relaxed whitespace-pre-line">{{ $review->content }}</p>

            <!-- Review Photos Gallery -->
            @if($review->photos->count() > 0)
            <div class="flex flex-col gap-1.5 pt-1">
                <span class="text-xs uppercase font-bold tracking-wider text-secondary-container">Foto Kunjungan ({{ $review->photos->count() }})</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($review->photos as $photo)
                    <div class="relative group rounded-xl overflow-hidden bg-surface-container border border-secondary/35 cursor-pointer shadow-sm aspect-square" onclick="openReviewPhotoModal('{{ Storage::url($photo->photo_path) }}', '{{ addslashes($review->user->name) }}')">
                        <img src="{{ Storage::url($photo->photo_path) }}" alt="Foto ulasan {{ $review->user->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy" />
                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#F9F6F0] text-[28px] drop-shadow">zoom_in</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
    <div class="flex justify-center mt-space-lg">
        {{ $reviews->links() }}
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="bg-surface-container-lowest rounded-2xl p-8 sm:p-10 border border-secondary/35 flex flex-col items-center justify-center gap-4 text-center shadow-sm">
        <div class="w-20 h-20 rounded-full bg-secondary/15 text-primary flex items-center justify-center border-2 border-secondary/40 shadow-sm">
            <span class="material-symbols-outlined text-[42px] text-secondary">rate_review</span>
        </div>
        <div class="flex flex-col gap-1 max-w-md">
            <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Belum Ada Ulasan Pengunjung</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                Jadilah pengunjung pertama yang membagikan kesan, informasi kondisi terkini, atau foto indah dari {{ $cagarBudaya->name }}.
            </p>
        </div>
        @auth
        <a href="{{ route('review.create', $cagarBudaya) }}" class="mt-2 px-6 py-3 rounded-xl bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-md text-label-md uppercase tracking-wider font-bold shadow-md hover:scale-105 transition-all flex items-center gap-2 border border-secondary/50">
            <span class="material-symbols-outlined text-secondary text-[20px]">add_comment</span>
            <span>Tulis Ulasan Pertama</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="mt-2 px-6 py-3 rounded-xl bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-md text-label-md uppercase tracking-wider font-bold shadow-md hover:scale-105 transition-all flex items-center gap-2 border border-secondary/50">
            <span class="material-symbols-outlined text-secondary text-[20px]">login</span>
            <span>Login untuk Memberi Ulasan</span>
        </a>
        @endauth
    </div>
    @endif
</div>

<!-- Lightbox Modal for Review Photos -->
<div id="reviewPhotoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 backdrop-blur-sm p-4 transition-opacity duration-300" onclick="closeReviewPhotoModal(event)">
    <div class="relative max-w-4xl w-full max-h-[92vh] flex flex-col items-center bg-surface-container-lowest rounded-2xl overflow-hidden border border-secondary/50 shadow-2xl" onclick="event.stopPropagation()">
        <!-- Modal Top Bar -->
        <div class="w-full px-5 py-3.5 flex items-center justify-between border-b border-secondary/25 bg-surface-container-lowest">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[20px]">photo_camera</span>
                <span id="reviewModalAuthor" class="text-sm font-bold text-primary">Foto Kunjungan</span>
            </div>
            <button type="button" onclick="closeReviewPhotoModal()" class="w-8 h-8 rounded-full bg-surface-container hover:bg-surface-container-high text-primary flex items-center justify-center transition-all cursor-pointer" title="Tutup (ESC)">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Image Container -->
        <div class="w-full flex items-center justify-center p-3 bg-black/40 overflow-hidden" style="max-height: calc(85vh - 60px);">
            <img id="reviewModalImg" src="" alt="Foto Ulasan" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-lg" />
        </div>
    </div>
</div>

<script>
function openReviewPhotoModal(url, author) {
    const modal = document.getElementById('reviewPhotoModal');
    const img = document.getElementById('reviewModalImg');
    const authorEl = document.getElementById('reviewModalAuthor');
    
    if (!modal || !img) return;

    img.src = url;
    if (authorEl && author) {
        authorEl.textContent = 'Foto oleh ' + author;
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

// Backward compatibility alias for any existing openPhotoModal calls
window.openPhotoModal = function(url) {
    openReviewPhotoModal(url, 'Pengunjung');
};

function closeReviewPhotoModal(e) {
    if (e && e.target && e.target.id !== 'reviewPhotoModal' && !e.target.closest('button')) {
        return;
    }
    const modal = document.getElementById('reviewPhotoModal');
    if (!modal) return;

    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('reviewPhotoModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeReviewPhotoModal();
        }
    }
});
</script>

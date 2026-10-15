<!-- Reviews Section -->
<div class="w-full mt-space-xl flex flex-col gap-space-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-secondary text-[24px]">rate_review</span>
            <h2 class="font-headline-sm text-headline-sm text-on-surface">Ulasan Pengunjung</h2>
            @if($reviews->total() > 0)
            <span class="px-2 py-1 rounded-full bg-primary-container text-secondary font-label-md text-label-md">{{ $reviews->total() }}</span>
            @endif
        </div>
        @auth
        <a href="{{ route('review.create', $cagarBudaya) }}" class="px-space-md py-2 rounded-lg bg-gradient-to-r from-primary-container to-secondary-container text-secondary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1 hover:scale-105 transition-transform shadow-md">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Tambah Review</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="px-space-md py-2 rounded-lg bg-surface-container-high hover:bg-surface-bright text-secondary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1 border border-secondary/30">
            <span class="material-symbols-outlined text-[18px]">login</span>
            <span>Login untuk Review</span>
        </a>
        @endauth
    </div>

    @if($reviews->count() > 0)
    <div class="space-y-space-md">
        @foreach($reviews as $review)
        <div class="bg-surface-container-low rounded-lg p-space-md border border-outline-variant/30 hover:border-secondary/50 transition-colors">
            <!-- Review Header -->
            <div class="flex items-start justify-between mb-space-sm">
                <div class="flex items-start gap-space-sm">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-container to-secondary-container flex items-center justify-center text-on-primary font-label-md text-label-md font-bold">
                        {{ substr($review->user->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="font-body-md text-body-md text-on-surface font-semibold">{{ $review->user->name }}</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @can('update', $review)
                <div class="flex gap-space-xs">
                    <a href="{{ route('review.edit', $review) }}" class="p-2 rounded-lg hover:bg-surface-container text-secondary transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                    <form action="{{ route('review.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Hapus review ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg hover:bg-surface-container text-error transition-colors" title="Delete">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </form>
                </div>
                @endcan
            </div>

            <!-- Rating Stars -->
            <div class="flex items-center gap-space-xs mb-space-sm">
                @for($i = 1; $i <= 5; $i++)
                <span class="material-symbols-outlined text-[18px] {{ $i <= $review->rating ? 'text-secondary fill-1' : 'text-on-surface-variant' }}">star</span>
                @endfor
                <span class="font-label-md text-label-md text-on-surface-variant ml-space-xs">{{ $review->rating }} / 5</span>
            </div>

            <!-- Review Content -->
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-space-md">{{ $review->content }}</p>

            <!-- Review Photos -->
            @if($review->photos->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
                @foreach($review->photos as $photo)
                <div class="relative group rounded-lg overflow-hidden bg-surface-container border border-outline-variant/30 cursor-pointer" onclick="openPhotoModal('{{ Storage::url($photo->photo_path) }}')">
                    <img src="{{ Storage::url($photo->photo_path) }}" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <span class="material-symbols-outlined text-white text-[32px]">zoom_in</span>
                    </div>
                </div>
                @endforeach
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
    <div class="bg-surface-container-low rounded-lg p-space-lg border border-outline-variant/30 flex flex-col items-center gap-space-md text-center">
        <span class="material-symbols-outlined text-on-surface-variant text-[48px]">rate_review</span>
        <div class="flex flex-col gap-space-xs">
            <p class="font-body-md text-body-md text-on-surface-variant">Belum ada ulasan dari pengunjung</p>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Jadilah yang pertama berbagi pengalaman Anda</p>
        </div>
    </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="photo-modal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 backdrop-blur-sm" onclick="closePhotoModal(event)">
    <div class="relative max-w-4xl max-h-screen flex items-center justify-center" onclick="event.stopPropagation()">
        <button onclick="closePhotoModal()" class="absolute top-4 right-4 p-2 rounded-full bg-surface-container hover:bg-surface-container-high text-on-surface">
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
        <img id="modal-image" src="" class="max-w-full max-h-[90vh] rounded-lg" />
    </div>
</div>

<script>
function openPhotoModal(src) {
    const modal = document.getElementById('photo-modal');
    const img = document.getElementById('modal-image');
    img.src = src;
    modal.classList.remove('hidden');
}

function closePhotoModal(event) {
    if (event && event.target.id !== 'photo-modal') return;
    const modal = document.getElementById('photo-modal');
    modal.classList.add('hidden');
}
</script>

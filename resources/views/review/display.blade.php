<!-- Reviews Section -->
<div class="w-full mt-space-xl flex flex-col gap-space-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[24px]">rate_review</span>
            <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Ulasan Pengunjung</h2>
            @if($reviews->total() > 0)
            <span class="px-2.5 py-0.5 rounded-full bg-primary text-[#F9F6F0] font-label-md text-label-md font-bold shadow-sm">{{ $reviews->total() }}</span>
            @endif
        </div>
        @auth
        <a href="{{ route('review.create', $cagarBudaya) }}" class="px-space-md py-2 rounded-lg bg-primary hover:bg-[#5A1414] text-[#F9F6F0] font-label-md text-label-md uppercase tracking-wider flex items-center gap-1 hover:scale-105 transition-transform shadow-sm font-bold border border-secondary/50">
            <span class="material-symbols-outlined text-secondary text-[18px]">add</span>
            <span>Tambah Review</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="px-space-md py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1 border border-secondary/40 font-bold">
            <span class="material-symbols-outlined text-secondary text-[18px]">login</span>
            <span>Login untuk Review</span>
        </a>
        @endauth
    </div>

    @if($reviews->count() > 0)
    <div class="space-y-space-md">
        @foreach($reviews as $review)
        <div class="bg-surface-container-lowest rounded-xl p-space-md border border-secondary/35 hover:border-secondary shadow-sm transition-all">
            <!-- Review Header -->
            <div class="flex items-start justify-between mb-space-sm">
                <div class="flex items-start gap-space-sm">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-[#F9F6F0] font-label-md text-label-md font-bold border border-secondary/40">
                        {{ substr($review->user->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="font-body-md text-body-md text-primary font-bold">{{ $review->user->name }}</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant font-medium">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @can('update', $review)
                <div class="flex gap-space-xs">
                    <a href="{{ route('review.edit', $review) }}" class="p-2 rounded-lg hover:bg-surface-container text-primary transition-colors" title="Edit">
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
                <span class="material-symbols-outlined text-[18px] {{ $i <= $review->rating ? 'text-secondary fill-1' : 'text-secondary/30' }}">star</span>
                @endfor
                <span class="font-label-md text-label-md text-secondary-container font-bold ml-space-xs">{{ $review->rating }} / 5</span>
            </div>

            <!-- Review Content -->
            <p class="font-body-md text-body-md text-on-surface leading-relaxed mb-space-md">{{ $review->content }}</p>

            <!-- Review Photos -->
            @if($review->photos->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
                @foreach($review->photos as $photo)
                <div class="relative group rounded-lg overflow-hidden bg-surface-container border border-secondary/30 cursor-pointer" onclick="openPhotoModal('{{ Storage::url($photo->photo_path) }}')">
                    <img src="{{ Storage::url($photo->photo_path) }}" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300" />
                    <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/50 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <span class="material-symbols-outlined text-[#F9F6F0] text-[32px]">zoom_in</span>
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
    <div class="bg-surface-container-lowest rounded-xl p-space-lg border border-secondary/35 flex flex-col items-center gap-space-md text-center shadow-sm">
        <span class="material-symbols-outlined text-primary text-[48px] opacity-40">rate_review</span>
        <div class="flex flex-col gap-space-xs">
            <p class="font-body-md text-body-md text-primary font-bold">Belum ada ulasan dari pengunjung</p>
            <p class="font-body-sm text-body-sm text-on-surface-variant font-medium">Jadilah yang pertama berbagi pengalaman Anda</p>
        </div>
    </div>
    @endif
</div>

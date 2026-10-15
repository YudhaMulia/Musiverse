{{-- Tombol game: garis tepi emas-merah + 3 panah yang beranimasi saat hover --}}
@props(['label'])

<button type="button" {{ $attributes->merge(['class' => 'btn-play']) }}>
    <span class="btn-play__text">{{ $label }}</span>
    <svg class="btn-play__arrow" viewBox="0 0 66 43" aria-hidden="true">
        <path class="one" d="M40.15 3.89 43.98.14a.5.5 0 0 1 .7 0l21.01 20.64a1 1 0 0 1 0 1.43L44.68 42.86a.5.5 0 0 1-.7 0l-3.82-3.75a.5.5 0 0 1 0-.71l16.84-16.54a.5.5 0 0 0 0-.71L40.15 4.61a.5.5 0 0 1 0-.72Z"/>
        <path class="two" d="M20.15 3.89 23.98.14a.5.5 0 0 1 .7 0l21.01 20.64a1 1 0 0 1 0 1.43L24.68 42.86a.5.5 0 0 1-.7 0l-3.82-3.75a.5.5 0 0 1 0-.71l16.84-16.54a.5.5 0 0 0 0-.71L20.15 4.61a.5.5 0 0 1 0-.72Z"/>
        <path class="three" d="M.15 3.89 3.98.14a.5.5 0 0 1 .7 0l21.01 20.64a1 1 0 0 1 0 1.43L4.68 42.86a.5.5 0 0 1-.7 0L.15 39.11a.5.5 0 0 1 0-.71l16.84-16.54a.5.5 0 0 0 0-.71L.15 4.61a.5.5 0 0 1 0-.72Z"/>
    </svg>
</button>

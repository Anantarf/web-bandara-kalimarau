@props(['src', 'alt', 'caption' => null, 'imgClass' => 'w-full h-auto', 'figureClass' => 'my-10 text-center'])

<figure {{ $attributes->class([$figureClass, 'group']) }} x-data="{ openModal: false }">
    <div class="relative cursor-zoom-in inline-block" @click="openModal = true">
        <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy" decoding="async" class="{{ $imgClass }} rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 transition-transform duration-500 group-hover:scale-[1.01]">

        <div class="absolute inset-0 bg-navy/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl flex items-center justify-center">
            <div class="bg-white/90 p-4 rounded-full text-navy shadow-lg backdrop-blur-sm transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
            </div>
        </div>
    </div>

    @if($caption ?? $alt)
        <figcaption class="mt-4 text-sm text-text-muted italic">{{ $caption ?? $alt }} (Klik untuk perbesar)</figcaption>
    @endif

    <template x-teleport="body">
        <div x-show="openModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-[#0a192f]/95 backdrop-blur-sm" @keydown.escape.window="openModal = false">
            <div x-show="openModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full h-full flex flex-col items-center justify-center"
                 @click="openModal = false">

                <button @click="openModal = false" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-white hover:text-gold p-2 bg-white/10 hover:bg-white/20 rounded-full backdrop-blur-md transition-all z-10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <img src="{{ $src }}" alt="{{ $alt }}" class="max-w-full max-h-full object-contain rounded-xl shadow-xl" @click.stop>
            </div>
        </div>
    </template>
</figure>

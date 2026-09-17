<x-layouts.public
    title="Halaman Tidak Ditemukan - Bandara Kalimarau"
    description="Maaf, halaman yang Anda cari tidak ditemukan."
>
    <div class="bg-surface py-4 sm:py-6 border-b border-border-soft">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => '404 — Tidak Ditemukan'],
            ]" />
        </div>
    </div>

    <div class="py-16 md:py-24 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <h1 x-show="loaded"
                x-cloak
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="text-8xl md:text-9xl font-extrabold text-navy-dark/10 leading-none mb-4">404</h1>

            <div x-show="loaded"
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 scale-0"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>

            <h2 x-show="loaded"
                x-cloak
                x-transition:enter="transition ease-out duration-500 delay-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="font-sans text-2xl md:text-3xl font-extrabold text-navy-dark leading-snug mb-4">Halaman Tidak Ditemukan</h2>

            <p x-show="loaded"
               x-cloak
               x-transition:enter="transition ease-out duration-500 delay-400"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="text-base md:text-lg text-text-muted mb-10 leading-relaxed">Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau tidak tersedia untuk saat ini.</p>

            <div x-show="loaded"
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 delay-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="bg-navy hover:bg-navy-dark text-white font-bold py-3 px-8 rounded-full transition shadow-md hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('contact.index') }}" class="bg-white hover:bg-surface text-navy-dark border-2 border-border-soft font-bold py-3 px-8 rounded-full transition hover:border-gold inline-flex items-center justify-center">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>

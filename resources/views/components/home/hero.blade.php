@props(['heroImages'])

<!-- Section 1: Hero -->
    <section x-data="{ activeIndex: 0, images: {{ json_encode($heroImages) }}, show: false, reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
             x-init="setTimeout(() => { show = true }, 150); if (! reducedMotion && images.length > 1) { const rotation = setInterval(() => { activeIndex = (activeIndex + 1) % images.length }, 5000); return () => clearInterval(rotation); }"
             class="relative w-full overflow-hidden bg-navy-dark h-screen h-[100dvh] min-h-[600px] flex flex-col justify-center">

        <img src="{{ $heroImages[0] }}" alt="Bandara Kalimarau" loading="eager" fetchpriority="high" decoding="async"
             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 ease-in-out"
             :class="activeIndex === 0 ? 'opacity-100' : 'opacity-0'">

        <template x-for="(image, index) in images.slice(1)" :key="image">
            <img :src="image" alt="Bandara Kalimarau" loading="lazy" decoding="async"
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 ease-in-out"
                 :class="activeIndex === index + 1 ? 'opacity-100' : 'opacity-0'">
        </template>

        <div class="absolute inset-0 bg-navy-dark/25 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-navy-dark/85 via-navy-dark/20 to-navy-dark/80"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-navy-dark/20 via-transparent to-navy-dark/20"></div>

        <div class="relative max-w-7xl mx-auto px-4 w-full h-full flex flex-col items-center justify-center pt-24">
            <div class="text-center w-full flex-1 flex flex-col justify-center items-center mt-16">
                <h2 x-show="show" x-transition:enter="transition-all ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-8 tracking-wide" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="font-sans text-white text-2xl sm:text-3xl lg:text-4xl font-semibold uppercase tracking-[0.12em] mb-6">Bandar Udara</h2>
                <h1 x-show="show" x-transition:enter="transition-all ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 scale-90 translate-y-12 blur-sm" x-transition:enter-end="opacity-100 scale-100 translate-y-0 blur-none" style="display: none;" class="font-sans text-white text-5xl sm:text-7xl lg:text-[5.5rem] font-bold tracking-tight leading-none drop-shadow-lg mb-10">Kalimarau</h1>

                <!-- Weather Widget -->
                <div x-data="weatherWidget" x-init="fetchWeather()"
                    x-show="show" x-transition:enter="transition-all ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-6 py-2.5 shadow-lg">

                    <svg x-show="icon === 'cloud'" style="display: none;" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    <svg x-show="icon === 'sun'" style="display: none;" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m14.485-7.071l-1.414 1.414M6.929 17.657l-1.414 1.414M17.657 17.657l-1.414-1.414M6.929 6.929L5.515 5.515M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                    <svg x-show="icon === 'moon'" style="display: none;" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 1020.354 15.354z"></path></svg>
                    <svg x-show="icon === 'rain'" style="display: none;" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 18.5v1M12 18.5v1M17 18.5v1M6.5 15.5h10a4.5 4.5 0 10-.28-8.99 5.5 5.5 0 00-10.57 1.68A3.75 3.75 0 006.5 15.5z"></path></svg>
                    <svg x-show="icon === 'lightning'" style="display: none;" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>

                    <span class="text-white font-medium text-sm sm:text-base" x-text="temp === '...' ? 'Memuat cuaca...' : `${temp}, ${desc} di Berau`">Memuat...</span>
                </div>
            </div>

            <!-- Pill Quick Links -->
            <div x-show="show" x-transition:enter="transition-all ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-500 delay-400" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="inline-flex flex-wrap justify-center items-center gap-4 sm:gap-8 bg-black/20 backdrop-blur-md border border-white/20 rounded-full px-6 sm:px-10 py-3 sm:py-4 mb-8 sm:mb-10 shadow-xl">
                <a href="{{ route('flights.index') }}" class="flex items-center gap-2.5 text-white hover:text-gold transition-colors px-2 py-1.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 21 4s-2 0-3.5 1.5L14 9 5.8 6.2c-.5-.2-1.1 0-1.4.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 4.1c.4.4.9.5 1.3.3l.5-.3c.5-.3.7-.9.5-1.4z"/></svg>
                    <span class="text-sm sm:text-base font-semibold">Jadwal Penerbangan</span>
                </a>
                <span class="w-px h-6 bg-white/20 my-auto hidden sm:block"></span>
                <a href="#fasilitas" class="flex items-center gap-2.5 text-white hover:text-gold transition-colors px-2 py-1.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="text-sm sm:text-base font-semibold">Fasilitas</span>
                </a>
            </div>

            <!-- Social Media Buttons -->
            <div x-show="show" x-transition:enter="transition-all ease-out duration-500 delay-[500ms]" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="relative w-[90%] max-w-4xl mb-8 sm:mb-12">
            <div class="flex flex-nowrap justify-center items-center gap-3 sm:gap-3 overflow-x-auto scrollbar-hide pb-2">
                <a href="https://instagram.com/bandarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center justify-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white w-9 h-9 sm:w-auto sm:h-auto sm:px-3 sm:py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    <span class="hidden sm:inline text-xs font-medium">@bandarakalimarau</span>
                </a>
                <a href="https://facebook.com/bandaraudarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center justify-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white w-9 h-9 sm:w-auto sm:h-auto sm:px-3 sm:py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                    <span class="hidden sm:inline text-xs font-medium">Bandar udara kalimarau</span>
                </a>
                <a href="https://tiktok.com/@bandarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center justify-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white w-9 h-9 sm:w-auto sm:h-auto sm:px-3 sm:py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.96-.5 3.95-1.54 5.6-1.63 2.59-4.76 4.1-7.85 3.52-2.58-.48-4.9-2.22-5.75-4.68-.89-2.55-.42-5.59 1.34-7.69 1.48-1.75 3.75-2.73 6.01-2.61v4.06c-1.25-.09-2.59.32-3.39 1.25-.97 1.11-.98 2.87-.26 4.1.86 1.48 2.89 2.07 4.54 1.41 1.53-.61 2.39-2.27 2.39-3.9v-16.32z"/></svg>
                    <span class="hidden sm:inline text-xs font-medium">@bandarakalimarau</span>
                </a>
                <a href="https://youtube.com/@bandarakalimarauberau7084" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center justify-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white w-9 h-9 sm:w-auto sm:h-auto sm:px-3 sm:py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    <span class="hidden sm:inline text-xs font-medium">@bandarakalimarauberau7084</span>
                </a>
            </div>
            <div class="sm:hidden pointer-events-none absolute right-0 top-0 bottom-2 w-10 bg-gradient-to-l from-black/40 to-transparent rounded-r-full"></div>
            </div>
        </div>
    </section>

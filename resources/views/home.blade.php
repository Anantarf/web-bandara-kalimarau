<x-layouts.public
    title="Bandara Kalimarau - Gerbang Udara Kabupaten Berau"
    description="Website resmi Bandara Kalimarau untuk informasi penerbangan, berita, layanan publik, PPID, kontak, dan pengaduan."
    :canonical="route('home')"
    :image="$heroImages[0]"
    :withHeaderPadding="false"
>
    <!-- Section 1: Hero -->
    <section x-data="{ activeIndex: 0, images: {{ json_encode($heroImages) }}, show: false, reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
             x-init="setTimeout(() => { show = true }, 150); if (! reducedMotion && images.length > 1) { const rotation = setInterval(() => { activeIndex = (activeIndex + 1) % images.length }, 5000); return () => clearInterval(rotation); }"
             class="relative w-full overflow-hidden bg-navy-dark h-[100dvh] min-h-[600px] flex flex-col justify-center">
        
        <template x-for="(image, index) in images" :key="index">
            <img :src="image" alt="Bandara Kalimarau" :loading="index === 0 ? 'eager' : 'lazy'"
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out" 
                 :class="activeIndex === index ? 'opacity-50' : 'opacity-0'">
        </template>

        <div class="absolute inset-0 bg-gradient-to-r from-navy-dark/95 via-navy-dark/70 to-transparent pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 w-full h-full flex flex-col items-center justify-center pt-24">
            <div class="text-center w-full flex-1 flex flex-col justify-center items-center mt-16">
                <h2 x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-100" x-transition:enter-start="opacity-0 translate-y-8 tracking-widest" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="font-sans text-white/90 text-2xl sm:text-3xl lg:text-4xl font-light uppercase tracking-[0.2em] mb-6">Bandar Udara</h2>
                <h1 x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 scale-90 translate-y-12 blur-sm" x-transition:enter-end="opacity-100 scale-100 translate-y-0 blur-none" style="display: none;" class="font-sans text-white text-5xl sm:text-7xl lg:text-[5.5rem] font-bold tracking-tight leading-none drop-shadow-lg mb-10">Kalimarau</h1>

                <!-- Weather Widget -->
                <div x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-6 py-2.5 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    <span class="text-white font-medium text-sm sm:text-base">28°C, Cerah di Berau</span>
                </div>
            </div>

            <!-- Pill Quick Links -->
            <div x-show="show" x-transition:enter="transition-all ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-1000 delay-700" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="inline-flex flex-wrap justify-center items-center gap-4 sm:gap-8 bg-black/20 backdrop-blur-md border border-white/20 rounded-full px-6 sm:px-10 py-3 sm:py-4 mb-8 sm:mb-10 shadow-2xl">
                <a href="{{ route('flights.index') }}" class="flex items-center gap-2.5 text-white hover:text-gold transition-colors px-2 py-1.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 21 4s-2 0-3.5 1.5L14 9 5.8 6.2c-.5-.2-1.1 0-1.4.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 4.1c.4.4.9.5 1.3.3l.5-.3c.5-.3.7-.9.5-1.4z"/></svg>
                    <span class="text-sm sm:text-[15px] font-semibold tracking-wide">Jadwal Penerbangan</span>
                </a>
                <span class="w-px h-6 bg-white/20 my-auto hidden sm:block"></span>
                <a href="#fasilitas" class="flex items-center gap-2.5 text-white hover:text-gold transition-colors px-2 py-1.5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span class="text-sm sm:text-[15px] font-semibold tracking-wide">Fasilitas</span>
                </a>
            </div>

            <!-- Social Media Buttons -->
            <div x-show="show" x-transition:enter="transition-all ease-out duration-1000 delay-[900ms]" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="flex flex-nowrap justify-start sm:justify-center items-center gap-2.5 sm:gap-3 mb-8 sm:mb-12 w-[90%] max-w-4xl overflow-x-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    /* Hide scrollbar for Chrome, Safari and Opera */
                    .overflow-x-auto::-webkit-scrollbar { display: none; }
                </style>
                <a href="https://instagram.com/bandarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    <span class="text-[11px] sm:text-xs font-medium tracking-wide">@bandarakalimarau</span>
                </a>
                <a href="https://facebook.com/bandaraudarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                    <span class="text-[11px] sm:text-xs font-medium tracking-wide">Bandar udara kalimarau</span>
                </a>
                <a href="https://tiktok.com/@bandarakalimarau" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.96-.5 3.95-1.54 5.6-1.63 2.59-4.76 4.1-7.85 3.52-2.58-.48-4.9-2.22-5.75-4.68-.89-2.55-.42-5.59 1.34-7.69 1.48-1.75 3.75-2.73 6.01-2.61v4.06c-1.25-.09-2.59.32-3.39 1.25-.97 1.11-.98 2.87-.26 4.1.86 1.48 2.89 2.07 4.54 1.41 1.53-.61 2.39-2.27 2.39-3.9v-16.32z"/></svg>
                    <span class="text-[11px] sm:text-xs font-medium tracking-wide">@bandarakalimarau</span>
                </a>
                <a href="https://youtube.com/@bandarakalimarauberau7084" target="_blank" rel="noopener noreferrer" class="shrink-0 flex items-center gap-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-full transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    <span class="text-[11px] sm:text-xs font-medium tracking-wide">@bandarakalimarauberau7084</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Section: Sambutan -->
    <section class="bg-surface py-16 lg:py-20 relative z-0">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-[minmax(0,1fr)_320px] gap-10 lg:gap-16 items-start scroll-animate opacity-0 translate-y-8 transition-all duration-[1000ms] ease-out">
                <div class="max-w-5xl">
                    <h2 class="font-sans text-lg md:text-xl font-bold text-navy uppercase tracking-wide mb-6">Sambutan dari Kepala Bandar Udara</h2>

                    <div class="space-y-7 text-text-muted">
                        @foreach($sambutan['teks'] as $paragraph)
                            <p class="font-sans italic text-lg md:text-xl leading-loose">"{{ $paragraph }}"</p>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        <h3 class="font-sans text-xl md:text-2xl font-extrabold text-navy leading-snug">{{ $sambutan['nama'] }}</h3>
                        <p class="text-text-muted text-base md:text-lg mt-1">{{ $sambutan['jabatan'] }}</p>
                    </div>
                </div>

                <div class="w-full max-w-xs lg:max-w-none mx-auto lg:mx-0">
                    <div class="aspect-[4/5] rounded-xl overflow-hidden bg-white shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)]">
                        <img src="{{ $sambutan['foto'] }}" alt="{{ $sambutan['nama'] }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Aktivitas -->
    @if($airportStat)
    <section class="bg-white py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-0 translate-y-8 transition-all duration-[1000ms] ease-out">
            <div class="text-center mb-12">
                <h2 class="font-sans text-3xl font-extrabold tracking-tight text-navy mb-2">Aktivitas Bandara</h2>
                <p class="text-text-muted text-base mt-2">Statistik pergerakan periode {{ $airportStat->period_name }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="py-4 md:py-0 flex flex-col items-center">
                    <div class="mb-5 flex justify-center">
                        <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-navy mb-2 tabular-nums stat-counter" data-target="{{ $airportStat->passenger_count }}">0</div>
                    <div class="text-text-muted font-medium uppercase tracking-wide text-sm">Penumpang</div>
                </div>
                <div class="py-4 md:py-0 flex flex-col items-center">
                    <div class="mb-5 flex justify-center">
                        <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 21 4s-2 0-3.5 1.5L14 9 5.8 6.2c-.5-.2-1.1 0-1.4.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 4.1c.4.4.9.5 1.3.3l.5-.3c.5-.3.7-.9.5-1.4z"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-navy mb-2 tabular-nums stat-counter" data-target="{{ $airportStat->flight_count }}">0</div>
                    <div class="text-text-muted font-medium uppercase tracking-wide text-sm">Pergerakan Pesawat</div>
                </div>
                <div class="py-4 md:py-0 flex flex-col items-center">
                    <div class="mb-5 flex justify-center">
                        <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-navy mb-2 tabular-nums stat-counter" data-target="{{ $airportStat->cargo_count }}">0</div>
                    <div class="text-text-muted font-medium uppercase tracking-wide text-sm">Kargo (Kg)</div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Section 4: Jadwal Penerbangan Ringkas -->
    @php
        $flightLogos = collect($mitra)->pluck('logo', 'nama')->toArray();
    @endphp
    <section class="bg-navy-dark py-16 lg:py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-0 translate-y-8 transition-all duration-[1000ms] ease-out delay-100"
             x-data="{
                tab: 'kedatangan',
                flights: {{ \Illuminate\Support\Js::from($flightSchedules->map(function ($f) use ($flightLogos) {
                    return [
                        'type' => $f->type,
                        'airline' => $f->airline,
                        'logo' => isset($flightLogos[$f->airline]) ? asset($flightLogos[$f->airline]) : null,
                        'initials' => collect(explode(' ', $f->airline))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode(''),
                        'flight_number' => $f->flight_number ?? '-',
                        'route' => $f->type === 'keberangkatan' ? $f->route_to : $f->route_from,
                        'time' => ($f->type === 'keberangkatan' ? $f->departure_time : $f->arrival_time)?->format('H:i') ?? '-',
                    ];
                })) }},
                get filteredFlights() {
                    return this.flights.filter(f => f.type === this.tab).slice(0, 5);
                }
             }">

            <!-- Section Title -->
            <div class="text-center mb-8">
                <h2 class="font-sans text-3xl font-extrabold tracking-tight text-white mb-2">Jadwal Penerbangan</h2>
                <p class="text-white/70 text-base mt-2">Informasi keberangkatan dan kedatangan terkini</p>
            </div>

            <!-- Header Toggle -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex rounded-full p-1 bg-white/5 border border-white/10 shadow-inner">
                    <button type="button" @click="tab = 'kedatangan'" :class="tab === 'kedatangan' ? 'bg-gold text-navy-dark shadow-md' : 'text-white/70 hover:text-white'" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        <svg class="w-4 h-4 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Kedatangan
                    </button>
                    <button type="button" @click="tab = 'keberangkatan'" :class="tab === 'keberangkatan' ? 'bg-gold text-navy-dark shadow-md' : 'text-white/70 hover:text-white'" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        <svg class="w-4 h-4 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Keberangkatan
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="min-w-[720px]">
                    <!-- Table Header -->
                    <div class="hidden md:grid grid-cols-[1.3fr_2.6fr_1fr_1fr] gap-4 px-8 py-3 text-white/50 text-[11px] font-bold tracking-wider uppercase mb-2">
                        <div>Maskapai</div>
                        <div x-text="tab === 'kedatangan' ? 'Dari' : 'Tujuan'"></div>
                        <div>Nomor</div>
                        <div>Waktu</div>
                    </div>

                    <div x-show="filteredFlights.length === 0" style="display: none;" class="px-6 py-12 text-center text-white/50 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-base font-medium">Belum ada jadwal aktif saat ini.</p>
                    </div>

                    <!-- Table Rows -->
                    <div x-show="filteredFlights.length > 0" class="flex flex-col gap-2">
                        <template x-for="(flight, index) in filteredFlights" :key="tab + index">
                            <div class="grid grid-cols-1 md:grid-cols-[1.3fr_2.6fr_1fr_1fr] gap-y-3 gap-x-4 items-center px-6 py-3.5 bg-[#14233a] rounded-xl hover:bg-[#1a2c49] transition-colors shadow-sm">

                                <!-- Maskapai -->
                                <div class="flex items-center gap-3">
                                    <template x-if="flight.logo">
                                        <div class="w-20 md:w-24 h-10 md:h-12 bg-white rounded-md p-2 shadow-sm flex items-center justify-center shrink-0">
                                            <img :src="flight.logo" :alt="flight.airline" class="max-w-full max-h-full object-contain">
                                        </div>
                                    </template>
                                    <template x-if="!flight.logo">
                                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-sm font-bold text-white shrink-0" x-text="flight.initials" :title="flight.airline"></div>
                                    </template>
                                </div>

                                <!-- Rute -->
                                <div class="font-bold text-white text-sm md:text-base leading-snug whitespace-nowrap">
                                    <span class="md:hidden text-white/40 text-xs font-normal uppercase mr-2" x-text="tab === 'kedatangan' ? 'Dari:' : 'Tujuan:'"></span>
                                    <span x-text="flight.route"></span>
                                </div>

                                <!-- Nomor -->
                                <div class="text-white/70 text-sm md:text-base font-medium whitespace-nowrap">
                                    <span class="md:hidden text-white/40 text-xs font-normal uppercase mr-2">Nomor:</span>
                                    <span x-text="flight.flight_number"></span>
                                </div>

                                <!-- Waktu -->
                                <div class="font-bold text-white text-sm md:text-base tabular-nums whitespace-nowrap">
                                    <span class="md:hidden text-white/40 text-xs font-normal uppercase mr-2">Waktu:</span>
                            <span x-text="flight.time"></span>
                        </div>
                    </div>
                </template>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('flights.index') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                    Lihat Jadwal Lengkap
                </a>
            </div>
        </div>
    </section>

    <!-- Section 5: Fasilitas Bandara -->
    <section id="fasilitas" class="py-16 lg:py-24 bg-surface">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-0 translate-y-8 transition-all duration-[1000ms] ease-out delay-100">
            <div class="flex flex-col sm:flex-row items-end justify-between mb-8 gap-4">
                <div>
                    <h2 class="font-sans text-3xl font-extrabold tracking-tight text-navy">Fasilitas Bandara</h2>
                    <p class="text-text-muted text-base mt-2">Kenyamanan dan pelayanan terbaik selama Anda berada di bandara.</p>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($facilities as $item)
                    <div class="group bg-white rounded-xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] hover:-translate-y-1.5 transition-all duration-500">
                        <a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="block w-full h-full">
                            <div class="relative overflow-hidden bg-navy-dark aspect-[4/3]">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-text-main text-lg mb-1.5 group-hover:text-gold transition-colors">{{ $item['title'] }}</h3>
                                <p class="text-text-muted text-sm leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-12">
                <a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                    Lihat Semua Fasilitas
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Section: Mitra Terkemuka -->
    <section class="py-16 lg:py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="font-sans text-3xl font-extrabold tracking-tight text-navy">Dipercaya oleh Mitra Terkemuka</h2>
                <p class="text-text-muted text-base mt-2">Kami bekerja sama dengan berbagai maskapai yang melayani rute langsung dan regional dari Bandara Kalimarau.</p>
            </div>

            <div class="partner-marquee" aria-label="Daftar maskapai mitra Bandara Kalimarau">
                <div class="partner-marquee__track">
                    @foreach(collect($mitra)->concat($mitra) as $item)
                        <div class="partner-marquee__item partner-marquee__item--{{ $item['slug'] }}" title="{{ $item['nama'] }}: {{ $item['rute'] }}">
                            @if($item['logo'])
                                <img src="{{ asset($item['logo']) }}" alt="{{ $item['nama'] }}" loading="lazy" decoding="async" class="partner-marquee__logo">
                            @else
                                <span class="partner-marquee__fallback">{{ $item['nama'] }}</span>
                            @endif
                            <span class="sr-only">{{ $item['nama'] }} melayani rute {{ $item['rute'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Berita Terkini -->
    <section class="py-16 lg:py-24 bg-navy-dark">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-0 translate-y-8 transition-all duration-[1000ms] ease-out delay-100">
            <div class="text-center mb-12">
                <h2 class="font-sans text-3xl font-extrabold tracking-tight text-white mb-2">Kabar Terbaru dari Gerbang Udara Anda</h2>
                <p class="text-white/70 text-base mt-2 max-w-2xl mx-auto">Ikuti terus informasi, acara, dan pengembangan terbaru langsung dari Bandar Udara Kalimarau.</p>
            </div>

            @if($latestPosts->count() > 0)
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($latestPosts->take(3) as $post)
                        <div class="bg-black/20 backdrop-blur-sm rounded-xl overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl hover:shadow-black/30 transition-all duration-300 border border-white/10">
                            <div class="relative overflow-hidden bg-navy-dark aspect-[16/10] shrink-0">
                                @if($post->featured_image_url)
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-navy-dark text-white/20">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="text-white/50 text-sm mb-3">{{ $post->published_at->translatedFormat('d M Y') }}</div>
                                <h3 class="font-sans font-extrabold text-white text-lg leading-snug mb-3 line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-gold transition-colors focus-visible:outline-none focus-visible:underline before:absolute before:inset-0">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-white/60 text-sm leading-relaxed line-clamp-2 mb-6 flex-1">{{ $post->excerpt }}</p>
                                <div class="text-gold font-semibold text-sm flex items-center gap-1 group w-fit mt-auto relative z-10">
                                    Baca Selengkapnya 
                                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        Lihat Semua Berita
                    </a>
                </div>
            @else
                <div class="bg-navy rounded-xl p-8 text-center border border-white/5">
                    <p class="text-white/50">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Handle fade-up animation
                        if (entry.target.classList.contains('scroll-animate')) {
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            entry.target.classList.remove('opacity-0', 'translate-y-8');
                        }

                        // Handle counter animation
                        if (entry.target.classList.contains('stat-counter')) {
                            const target = parseInt(entry.target.getAttribute('data-target'), 10);
                            if (target > 0) {
                                const duration = 2000; // 2 seconds
                                const start = performance.now();
                                const step = (timestamp) => {
                                    // Use easeOutExpo logic for smoother slowdown at the end
                                    let progress = (timestamp - start) / duration;
                                    if (progress > 1) progress = 1;
                                    const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                                    
                                    const currentVal = Math.floor(easeProgress * target);
                                    entry.target.innerText = new Intl.NumberFormat('id-ID').format(currentVal);
                                    
                                    if (progress < 1) {
                                        window.requestAnimationFrame(step);
                                    } else {
                                        entry.target.innerText = new Intl.NumberFormat('id-ID').format(target);
                                    }
                                };
                                window.requestAnimationFrame(step);
                            } else {
                                entry.target.innerText = "0";
                            }
                        }

                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            document.querySelectorAll('.scroll-animate, .stat-counter').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</x-layouts.public>

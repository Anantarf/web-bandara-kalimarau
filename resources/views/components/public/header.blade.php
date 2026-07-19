@props(['transparent' => false])

@php
    $navGroups = [
        'Informasi Publik' => [
            ['label' => 'Profil Bandara', 'slug' => 'profil-bandara-kalimarau'],
            ['label' => 'Maklumat Pelayanan', 'slug' => 'maklumat-pelayanan'],
            ['label' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi'],
        ],
        'Layanan' => [
            ['label' => 'Fasilitas Bandara', 'slug' => 'fasilitas-bandara'],
            ['label' => 'Tarif Kebandarudaraan', 'slug' => 'tarif-kebandarudaraan'],
            ['label' => 'Standar Pelayanan', 'slug' => 'standar-pelayanan'],
            ['label' => 'Pengajuan Pas Bandara', 'url' => 'https://idpas.kalimarau-airport.com', 'external' => true],
        ],
        'Informasi' => [
            ['label' => 'Berita Terkini', 'route' => 'posts.index'],
        ],
        'Pengaduan' => [
            ['label' => 'Survey Kepuasan', 'slug' => 'survey-kepuasan-masyarakat-internal'],
            ['label' => 'SIMADU', 'slug' => 'simadu'],
            ['label' => 'SP4N Lapor', 'slug' => 'sp4n-lapor'],
            ['label' => 'Hasil & Tindak Lanjut', 'slug' => 'hasil-dan-tindak-lanjut'],
        ],
    ];

    $ppidGroups = [
        ['label' => 'Profil PPID', 'slug' => 'profile-ppid'],
        ['label' => 'Layanan Informasi', 'slug' => 'layanan-informasi'],
        ['label' => 'Regulasi & Prosedur', 'slug' => 'regulasi'],
    ];
@endphp
<header class="w-full fixed top-0 z-50 transition-all duration-500 ease-out"
        x-data="{ mobileOpen: false, scrolled: false, transparent: {{ $transparent ? 'true' : 'false' }} }"
        @scroll.window="scrolled = (window.pageYOffset > 10)"
        :class="(transparent && !scrolled) ? 'bg-transparent py-4' : 'bg-white shadow-md border-b border-border-soft py-2'">

    <!-- Main header -->
    <div class="max-w-7xl mx-auto px-4 lg:px-6 flex items-center justify-between h-16 md:h-20 transition-all duration-500 ease-out">

        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group py-2">
            <img src="{{ asset('images/logo-as.png') }}" alt="Bandara Kalimarau"
                    class="w-auto object-contain h-11 md:h-12 transition-transform duration-300 group-hover:scale-105 filter drop-shadow-md"
                    :class="(transparent && !scrolled) ? 'brightness-0 invert' : ''"
                    onerror="this.src='https://via.placeholder.com/200x50?text=Kalimarau'">
        </a>

        <!-- Desktop nav -->
        <nav class="hidden lg:flex flex-1 justify-center items-center gap-2 xl:gap-3" :class="(transparent && !scrolled) ? 'text-white' : 'text-navy'">
            <a href="{{ route('home') }}" class="group relative px-2 py-2 text-[15px] font-bold hover:text-gold transition-colors tracking-wide">
                Beranda
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition-all duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
            </a>

                @foreach($navGroups as $groupLabel => $items)
                <div class="relative group/dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="true" class="group relative flex items-center gap-1 px-2 py-2 text-[15px] font-bold hover:text-gold transition-colors tracking-wide">
                        {{ $groupLabel }}
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/dropdown:-rotate-180 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition-all duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
                    </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-250" 
                             x-transition:enter-start="opacity-0 translate-y-3" 
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-0 mt-3 bg-white border border-navy/5 rounded-2xl shadow-[0_15px_50px_-10px_rgba(20,35,58,0.15)] py-2.5 min-w-60 z-50 overflow-hidden" style="display: none;">
                            @foreach($items as $item)
                                <a href="{{ isset($item['route']) ? route($item['route']) : ($item['external'] ?? false ? $item['url'] : route('pages.show', $item['slug'])) }}"
                                   @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                                   class="group/item flex items-center px-5 py-2.5 text-[14px] font-semibold text-navy/80 hover:bg-[#f5f7fa] hover:text-navy transition-all duration-350">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold opacity-0 -translate-x-2 mr-0 w-0 transition-all duration-300 group-hover/item:opacity-100 group-hover/item:translate-x-0 group-hover/item:w-2 group-hover/item:mr-2"></span>
                                    <span>{{ $item['label'] }}</span>
                                    @if($item['external'] ?? false)
                                        <svg class="w-3.5 h-3.5 ml-1.5 text-text-muted transition-transform group-hover/item:translate-x-0.5 group-hover/item:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            <!-- PPID Dropdown (Single Level) -->
            <div class="relative group/ppid" x-data="{ openPpid: false }" @mouseenter="openPpid = true" @mouseleave="openPpid = false" @click.outside="openPpid = false" @keydown.escape.window="openPpid = false">
                <button type="button" @click="openPpid = !openPpid" :aria-expanded="openPpid.toString()" aria-haspopup="true" class="group relative flex items-center gap-1 px-2 py-2 text-[15px] font-bold hover:text-gold transition-colors tracking-wide">
                    PPID
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover/ppid:-rotate-180 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition-all duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
                </button>
                    <div x-show="openPpid" 
                          x-transition:enter="transition ease-out duration-250" 
                          x-transition:enter-start="opacity-0 translate-y-3" 
                          x-transition:enter-end="opacity-100 translate-y-0"
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100 translate-y-0" 
                          x-transition:leave-end="opacity-0 translate-y-2"
                          class="absolute top-full right-0 mt-3 bg-white border border-navy/5 rounded-2xl shadow-[0_15px_50px_-10px_rgba(20,35,58,0.15)] py-2.5 min-w-64 z-50 overflow-hidden" style="display: none;">
                        @foreach($ppidGroups as $item)
                            <a href="{{ route('pages.show', $item['slug']) }}"
                               class="group/item flex items-center px-5 py-2.5 text-[14px] font-semibold text-navy/80 hover:bg-[#f5f7fa] hover:text-navy transition-all duration-350">
                                <span class="w-1.5 h-1.5 rounded-full bg-gold opacity-0 -translate-x-2 mr-0 w-0 transition-all duration-300 group-hover/item:opacity-100 group-hover/item:translate-x-0 group-hover/item:w-2 group-hover/item:mr-2"></span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('contact.index') }}" class="group relative px-2 py-2 text-[15px] font-bold hover:text-gold transition-colors tracking-wide">
                    Kontak
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition-all duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
                </a>
            </nav>

            <div class="hidden lg:flex items-center shrink-0">
                <a href="/admin" class="flex items-center gap-2 bg-gold text-white px-4 xl:px-5 py-2 rounded-full text-[14px] font-bold hover:bg-gold-light hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Masuk
                </a>
            </div>

            <!-- Mobile menu button -->
            <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" aria-controls="mobile-navigation" class="lg:hidden p-2 -mr-2 hover:bg-white/10 rounded-lg transition-colors" :class="(transparent && !scrolled) ? 'text-white' : 'text-navy'" aria-label="Menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

    <!-- Mobile drawer -->
    <div id="mobile-navigation" x-show="mobileOpen" @keydown.escape.window="mobileOpen = false" class="lg:hidden bg-white border-b border-border-soft shadow-lg" style="display: none;" x-data="{ expanded: null }">
        <nav class="max-w-7xl mx-auto px-4 py-3 space-y-0.5">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">Beranda</a>

            @foreach($navGroups as $groupLabel => $items)
                <div>
                    <button type="button" @click="expanded = expanded === '{{ $groupLabel }}' ? null : '{{ $groupLabel }}'" :aria-expanded="(expanded === '{{ $groupLabel }}').toString()" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">
                        <span>{{ $groupLabel }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded === '{{ $groupLabel }}' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded === '{{ $groupLabel }}'" class="pl-4 pb-1 space-y-0.5" style="display: none;">
                        @foreach($items as $item)
                            <a href="{{ isset($item['route']) ? route($item['route']) : ($item['external'] ?? false ? $item['url'] : route('pages.show', $item['slug'])) }}"
                               @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                               class="flex items-center px-3 py-2 text-sm text-text-muted hover:text-navy rounded-md">
                                {{ $item['label'] }}
                                @if($item['external'] ?? false)
                                    <svg class="w-3.5 h-3.5 ml-1.5 text-text-muted" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- PPID Mobile Accordion -->
            <div>
                <button type="button" @click="expanded = expanded === 'PPID' ? null : 'PPID'" :aria-expanded="(expanded === 'PPID').toString()" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">
                    <span>PPID</span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded === 'PPID' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="expanded === 'PPID'" class="pl-4 pb-1 space-y-0.5" style="display: none;">
                    @foreach($ppidGroups as $item)
                        <a href="{{ route('pages.show', $item['slug']) }}"
                           class="flex items-center px-3 py-2 text-sm text-text-muted hover:text-navy rounded-md">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('contact.index') }}" class="block px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">Kontak</a>
            <div class="pt-2 pb-1">
                <a href="tel:08526214614" class="flex items-center gap-2 px-3 py-2 text-sm text-navy font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.265-3.965-6.861-6.86l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                    0852 6214 6214
                </a>
            </div>
        </nav>
    </div>
</header>

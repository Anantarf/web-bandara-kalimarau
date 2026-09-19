@props(['transparent' => false])

@php
    $navGroups = [
        'Tentang Kami' => [
            ['label' => 'Profil Bandara', 'slug' => 'profil-bandara-kalimarau'],
            ['label' => 'Fasilitas Bandara', 'slug' => 'fasilitas-bandara'],
            ['label' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi'],
        ],
        'Layanan' => [
            ['label' => 'Tarif Kebandarudaraan', 'slug' => 'tarif-kebandarudaraan'],
            ['label' => 'Standar Pelayanan', 'slug' => 'standar-pelayanan'],
            ['label' => 'Pengajuan Pas Bandara', 'slug' => 'pengajuan-pas-bandara'],
        ],
        'Informasi' => [
            ['label' => 'Berita Terkini', 'route' => 'posts.index'],
            ['label' => 'FAQ Lengkap', 'route' => 'faq'],
        ],
        'Survey dan Pengaduan' => [
            ['label' => 'Survey Kepuasan & Hasil Tindak Lanjut', 'slug' => 'survey-kepuasan-masyarakat-internal'],
            ['label' => 'SIMADU', 'slug' => 'simadu'],
            ['label' => 'SP4N Lapor', 'slug' => 'sp4n-lapor'],
        ],
    ];
@endphp
<header class="fixed inset-x-0 top-0 z-50 w-full overflow-x-clip transition duration-300 ease-out"
        x-data="{ mobileOpen: false, scrolled: false, transparent: {{ $transparent ? 'true' : 'false' }} }"
        @scroll.window="scrolled = (window.pageYOffset > 10)"
        :class="(transparent && !scrolled) ? 'bg-transparent py-4' : 'bg-white shadow-md border-b border-border-soft py-2'">

    <x-public.announcement-banner />

    <!-- Main header -->
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 transition duration-300 ease-out md:h-20 lg:px-6">

        <a href="{{ route('home') }}" class="group flex min-w-0 shrink-0 items-center py-2">
            <img src="{{ asset('images/logo-as.png') }}" alt="Bandara Kalimarau"
                    class="h-10 w-auto max-w-[11rem] object-contain transition-transform duration-300 group-hover:scale-[1.02] md:h-11 md:max-w-[13rem]"
                    :class="(transparent && !scrolled) ? 'brightness-0 invert drop-shadow-md' : 'drop-shadow-md'"
                    onerror="this.onerror=null;this.src='{{ asset('images/logo-header.png') }}'">
        </a>

        <!-- Desktop nav -->
        <nav class="hidden min-w-0 flex-1 items-center justify-center gap-2 lg:flex xl:gap-4" :class="(transparent && !scrolled) ? 'text-white' : 'text-navy'">
            <a href="{{ route('home') }}" class="group relative px-2 py-2 text-sm font-bold hover:text-gold transition-colors">
                Beranda
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
            </a>

            @foreach($navGroups as $groupLabel => $items)
                <div class="relative group/dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="true" class="group relative flex items-center gap-1 px-2 py-2 text-sm font-bold hover:text-gold transition-colors">
                        {{ $groupLabel }}
                        <svg class="w-4 h-4 transition-transform duration-300 opacity-70" :class="{ '-rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition duration-300 rounded-full" :class="open ? 'w-[calc(100%-1.5rem)]' : 'w-0 group-hover:w-[calc(100%-1.5rem)]'"></span>
                    </button>
                    <div x-cloak
                         x-show="open"
                         x-transition:enter="transition ease-out duration-250"
                         x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute top-full left-0 mt-3 bg-white border border-navy/5 rounded-xl shadow-lg shadow-navy-dark/10 py-2 min-w-60 z-50 overflow-hidden">
                        @foreach($items as $item)
                            <a href="{{ isset($item['route']) ? route($item['route']) : (isset($item['url']) ? $item['url'] : route('pages.show', $item['slug'])) }}"
                               @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                               class="group flex items-center px-5 py-2.5 text-sm font-semibold text-navy/80 hover:bg-surface hover:text-navy transition-colors duration-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gold opacity-0 scale-75 group-hover:opacity-100 group-hover:scale-100 mr-2 transition duration-200"></span>
                                <span>{{ $item['label'] }}</span>
                                @if($item['external'] ?? false)
                                    <svg class="w-3.5 h-3.5 ml-1.5 text-text-muted transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <a href="https://hubud.kemenhub.go.id/upbu/kalimarau/ppid/index" target="_blank" rel="noopener noreferrer" class="group relative px-2 py-2 text-sm font-bold hover:text-gold transition-colors inline-flex items-center gap-1">
                PPID
                <svg class="w-3.5 h-3.5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
            </a>
            <a href="{{ route('contact.index') }}" class="group relative px-2 py-2 text-sm font-bold hover:text-gold transition-colors">
                Kontak
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gold transition duration-300 group-hover:w-[calc(100%-1.5rem)] rounded-full"></span>
            </a>
        </nav>

        <!-- Mobile menu button -->
        <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" aria-controls="mobile-navigation" class="lg:hidden p-2.5 -mr-2.5 hover:bg-white/10 rounded-lg transition-colors" :class="(transparent && !scrolled) ? 'text-white' : 'text-navy'" aria-label="Menu">
            <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <!-- Mobile drawer -->
    <div id="mobile-navigation" x-cloak x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300 transform origin-top"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform origin-top"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @keydown.escape.window="mobileOpen = false" class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-border-soft shadow-lg shadow-navy-dark/10 z-40" x-data="{ expanded: null }">
        <nav class="max-w-7xl mx-auto px-4 py-3 space-y-0.5 h-[calc(100vh-4rem)] overflow-y-auto">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">Beranda</a>

            @foreach($navGroups as $groupLabel => $items)
                <div>
                    <button type="button" @click="expanded = expanded === '{{ $groupLabel }}' ? null : '{{ $groupLabel }}'" :aria-expanded="(expanded === '{{ $groupLabel }}').toString()" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">
                        <span>{{ $groupLabel }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded === '{{ $groupLabel }}' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded === '{{ $groupLabel }}'" x-cloak class="pl-4 pb-1 space-y-0.5">
                        @foreach($items as $item)
                            <a href="{{ isset($item['route']) ? route($item['route']) : (isset($item['url']) ? $item['url'] : route('pages.show', $item['slug'])) }}"
                               @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                                class="flex items-center px-3 py-2 text-sm text-text-muted hover:text-navy rounded-md">
                                <span>{{ $item['label'] }}</span>
                                @if($item['external'] ?? false)
                                    <svg class="w-3.5 h-3.5 ml-1.5 text-text-muted" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <a href="https://hubud.kemenhub.go.id/upbu/kalimarau/ppid/index" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">
                <span>PPID</span>
                <svg class="w-4 h-4 text-text-muted" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
            <a href="{{ route('contact.index') }}" class="block px-3 py-2.5 text-sm font-medium text-text-main hover:text-navy rounded-md">Kontak</a>
            <div class="pt-2 pb-1">
                <a href="tel:085262146214" class="flex items-center gap-2 px-3 py-2 text-sm text-navy font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.265-3.965-6.861-6.86l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                    0852 6214 6214
                </a>
            </div>
        </nav>
    </div>
</header>

@php
    $groups = [
        'Tentang PPID' => ['profil', 'visi-misi', 'tugas-dan-fungsi', 'struktur-organisasi', 'struktur-organisasi-pelaksana-upt', 'regulasi'],
        'Informasi Publik' => ['informasi-berkala', 'informasi-setiap-saat', 'informasi-serta-merta', 'formulir-pengajuan-informasi'],
        'Pelayanan' => ['prosedur-permohonan-informasi', 'prosedur-keberatan-informasi', 'prosedur-sengketa-informasi-publik'],
        'Kritik dan Saran' => ['kritik-saran'],
    ];
    $currentSub = array_search($page->slug, $ppidMap, true) ?: null;
    $activeGroup = collect($groups)->search(fn ($subs) => in_array($currentSub, $subs)) ?: 'Informasi Publik';
@endphp

<x-layouts.public
    :title="($page->seo_title ?: ($currentSub ? $page->title : 'PPID')) . ' - Bandara Kalimarau'"
    :description="$page->seo_description ?: 'Informasi PPID UPBU Kelas I Kalimarau.'"
    :canonical="$currentSub ? route('ppid.show', $currentSub) : route('ppid.show')"
    :image="$page->featured_image_url ?? asset('images/logo-header.png')"
>

    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-7xl">
            @php
                $breadcrumbItems = [['label' => 'Beranda', 'url' => route('home')]];
                $breadcrumbItems[] = $currentSub
                    ? ['label' => 'PPID', 'url' => route('ppid.show')]
                    : ['label' => 'PPID'];
                if ($currentSub) {
                    $breadcrumbItems[] = ['label' => $page->title];
                }
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
    </div>

    <!-- Header -->
    <div class="pt-12 pb-12 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 max-w-7xl text-center md:text-left">
            <h1 class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6" 
                x-show="loaded" 
                x-transition:enter="transition-all ease-out duration-1000 delay-100" 
                x-transition:enter-start="opacity-0 translate-y-8" 
                x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;">{{ $currentSub ? $page->title : 'Layanan PPID' }}</h1>
                
            <div class="h-1.5 w-20 bg-gold-light mx-auto md:mx-0 rounded-full mb-6 origin-left" 
                 x-show="loaded" 
                 x-transition:enter="transition-all ease-out duration-1000 delay-300" 
                 x-transition:enter-start="opacity-0 scale-0" 
                 x-transition:enter-end="opacity-100 scale-100"
                 style="display: none;"></div>
                 
            <p class="text-xl text-gray-500 text-pretty leading-relaxed max-w-3xl mx-auto md:mx-0" 
               x-show="loaded" 
               x-transition:enter="transition-all ease-out duration-1000 delay-500" 
               x-transition:enter-start="opacity-0 translate-y-4" 
               x-transition:enter-end="opacity-100 translate-y-0"
               style="display: none;">Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau.</p>
        </div>
    </div>

    <div class="py-10 bg-gray-50 min-h-[500px]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-6 relative" x-data="{ activeSection: '' }" @scroll.window="
                let sections = document.querySelectorAll('h3[id]');
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 150) {
                        current = section.getAttribute('id');
                    }
                });
                activeSection = current;
            ">

                <!-- Sidebar Navigation (Desktop) / Accordion (Mobile) -->
                <aside class="w-full lg:w-1/4" x-show="loaded" x-transition:enter="transition-all ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24" x-data="{ activeGroup: '{{ $activeGroup }}' }">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 hidden lg:block">
                            <h3 class="font-bold text-gray-800">Menu PPID</h3>
                        </div>

                        @foreach($groups as $groupName => $subs)
                            <div class="border-b border-gray-100">
                                <button @click="activeGroup = activeGroup === '{{ $groupName }}' ? '' : '{{ $groupName }}'" class="w-full text-left px-5 py-4 font-semibold text-gray-800 flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors">
                                    {{ $groupName }}
                                    <svg class="w-4 h-4 text-gray-500 transform transition-transform" :class="{ 'rotate-180': activeGroup === '{{ $groupName }}' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="activeGroup === '{{ $groupName }}'" class="pb-2 space-y-1">
                                    @foreach($subs as $sub)
                                        <a href="{{ route('ppid.show', $sub) }}" class="block text-sm py-2 px-5 border-l-4 {{ $currentSub === $sub ? 'text-blue-700 font-medium bg-blue-50 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50 border-transparent' }} focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                            {{ $ppidTitles[$sub] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>

                <!-- Content Area -->
                @php
                    $headings = [];
                    preg_match_all('/<(h[234])[^>]*>(.*?)<\/\1>/i', $page->content, $matches);
                    
                    if (!empty($matches[2])) {
                        foreach ($matches[2] as $index => $text) {
                            $cleanText = strip_tags($text);
                            $id = \Illuminate\Support\Str::slug($cleanText);
                            if (strlen($cleanText) > 2 && strlen($cleanText) < 60) {
                                $headings[] = [
                                    'id' => $id,
                                    'text' => $cleanText
                                ];
                            }
                        }
                    }
                    
                    $contentWithIds = preg_replace_callback('/<(h[234])([^>]*)>(.*?)<\/\1>/i', function($m) {
                        $tag = $m[1];
                        $existingAttrs = $m[2];
                        $content = $m[3];
                        
                        $id = \Illuminate\Support\Str::slug(strip_tags($content));
                        
                        $newClasses = 'scroll-mt-32';
                        
                        if (strpos($existingAttrs, 'id="') === false) {
                            $existingAttrs .= ' id="' . $id . '"';
                        }
                        
                        if (strpos($existingAttrs, 'class="') !== false) {
                            $attrs = preg_replace('/class="/', 'class="' . $newClasses . ' ', $existingAttrs);
                        } else {
                            $attrs = $existingAttrs . ' class="' . $newClasses . '"';
                        }
                        
                        return "<{$tag}{$attrs}>{$content}</{$tag}>";
                    }, $page->content);

                    $showToc = count($headings) > 0;
                @endphp

                <main class="w-full {{ $showToc ? 'lg:w-1/2' : 'lg:w-3/4' }}" x-show="loaded" x-transition:enter="transition-all ease-out duration-1000 delay-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                        @if($currentSub)
                            <h2 class="subsection-title mb-6">{{ $page->title }}</h2>
                        @endif

                        @if($currentSub === 'profil')
                            @php
                                $ppidImages = [
                                    asset('images/ppid/ppid-1.jpg'),
                                    asset('images/ppid/ppid-2.jpg'),
                                    asset('images/ppid/ppid-3.jpg'),
                                ];
                            @endphp
                            <figure class="not-prose mb-8 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm relative group aspect-video"
                                    x-data="{ activeIndex: 0, images: {{ json_encode($ppidImages) }}, reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
                                    x-init="if (! reducedMotion && images.length > 1) { setInterval(() => { activeIndex = (activeIndex + 1) % images.length }, 5000) }">
                                <div class="absolute left-4 top-4 z-30 flex items-center gap-3 rounded-full bg-white/92 px-3.5 py-2 shadow-[0_12px_28px_-18px_rgba(12,45,107,0.5)] ring-1 ring-navy/10 backdrop-blur-md">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white ring-1 ring-border-soft">
                                        <img src="{{ asset('images/ppid/logo-ppid.png') }}" alt="Logo PPID" loading="lazy" decoding="async" class="h-7 w-auto object-contain">
                                    </span>
                                    <span class="pr-1 text-sm font-extrabold leading-none text-navy">PPID Kalimarau</span>
                                </div>
                                <template x-for="(image, index) in images" :key="index">
                                    <img :src="image" alt="Dokumentasi PPID Bandara Kalimarau"
                                         class="absolute inset-0 w-full h-full object-cover object-center transition-[opacity,transform] duration-[1600ms] ease-out will-change-[opacity,transform]"
                                         :class="activeIndex === index ? 'opacity-100 group-hover:scale-[1.025]' : 'opacity-0 scale-100'">
                                </template>
                                <div class="absolute inset-0 bg-gradient-to-t from-navy-dark/30 via-transparent to-white/5 pointer-events-none z-10"></div>
                                <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl pointer-events-none z-20"></div>
                            </figure>
                        @endif

                        @if(trim(strip_tags($page->content)) === '')
                            <div class="p-12 text-center bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">Belum ada konten</h3>
                                <p class="text-gray-500 text-sm">Halaman ini sedang dalam proses pembaruan.</p>
                            </div>
                        @else
                            <div class="prose prose-lg md:prose-xl prose-blue max-w-none prose-headings:font-bold prose-headings:text-navy-dark prose-a:text-blue-600 prose-img:rounded-xl">
                                {!! $contentWithIds !!}
                            </div>
                        @endif
                    </div>
                </main>

                <!-- Table of Contents Sidebar -->
                @if($showToc)
                    <aside class="hidden lg:block lg:w-1/4" x-show="loaded" x-transition:enter="transition-all ease-out duration-1000 delay-900" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="sticky top-24 bg-gray-100/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-sm">
                            <h4 class="text-sm font-bold text-navy-dark uppercase tracking-wider mb-4">Daftar Isi</h4>
                            <ul class="space-y-3 text-sm">
                                @foreach($headings as $heading)
                                    <li>
                                        <a href="#{{ $heading['id'] }}"
                                           class="block transition-all duration-200 hover:text-gold focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded"
                                           :class="activeSection === '{{ $heading['id'] }}' ? 'text-gold font-bold translate-x-1' : 'text-gray-500'">
                                            {{ $heading['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </div>
</x-layouts.public>

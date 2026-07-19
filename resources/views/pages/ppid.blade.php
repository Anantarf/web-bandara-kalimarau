@php
    $groups = [
        'Tentang PPID' => ['profil', 'visi-misi', 'tugas-dan-fungsi', 'struktur-organisasi', 'struktur-organisasi-pelaksana-upt', 'regulasi'],
        'Informasi Publik' => ['informasi-berkala', 'informasi-setiap-saat', 'informasi-serta-merta', 'formulir-pengajuan-informasi'],
        'Pelayanan' => ['maklumat-pelayanan-standar-biaya', 'prosedur-permohonan-informasi', 'prosedur-keberatan-informasi', 'prosedur-sengketa-informasi-publik'],
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
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-navy">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li class="{{ $currentSub ? 'flex items-center' : '' }}">
                        @if($currentSub)
                            <a href="{{ route('ppid.show') }}" class="text-gray-500 hover:text-navy">PPID</a>
                        @else
                            <span class="text-gray-800 font-medium" aria-current="page">PPID</span>
                        @endif
                    </li>
                    @if($currentSub)
                        <li class="flex items-center">
                            <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                            <span class="text-gray-800 font-medium" aria-current="page">{{ $page->title }}</span>
                        </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="pt-12 pb-12 bg-white">
        <div class="container mx-auto px-4 max-w-7xl text-center md:text-left">
            <h1 class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-4">{{ $currentSub ? $page->title : 'Layanan PPID' }}</h1>
            <div class="h-1.5 w-20 bg-gold-light rounded-full mb-4 mx-auto md:mx-0"></div>
            <p class="text-lg text-gray-500 max-w-3xl mx-auto md:mx-0">Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau.</p>
        </div>
    </div>

    <div class="py-10 bg-gray-50 min-h-[500px]">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Sidebar Navigation (Desktop) / Accordion (Mobile) -->
                <aside class="w-full lg:w-1/4">
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
                <main class="w-full lg:w-3/4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                        @if($currentSub)
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $page->title }}</h2>
                        @endif

                        @if(trim(strip_tags($page->content)) === '')
                            <div class="p-12 text-center bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">Belum ada konten</h3>
                                <p class="text-gray-500 text-sm">Halaman ini sedang dalam proses pembaruan.</p>
                            </div>
                        @else
                            <div class="prose prose-blue max-w-none">
                                {!! $page->content !!}
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-layouts.public>

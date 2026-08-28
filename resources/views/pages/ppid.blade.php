@php
    $currentSub = array_search($page->slug, $ppidMap, true) ?: null;
@endphp

<x-layouts.public
    :title="($page->seo_title ?: ($currentSub ? $page->title : 'PPID')) . ' - Bandara Kalimarau'"
    :description="$page->seo_description ?: 'Informasi PPID UPBU Kelas I Kalimarau.'"
    :canonical="$currentSub ? route('ppid.show', $currentSub) : route('ppid.show')"
    :image="$page->featured_image_url ?? asset('images/logo-header.png')"
>

    @php
        $breadcrumbItems = [['label' => 'Beranda', 'url' => route('home')]];
        $breadcrumbItems[] = $currentSub
            ? ['label' => 'PPID', 'url' => route('ppid.show')]
            : ['label' => 'PPID'];
        if ($currentSub) {
            $breadcrumbItems[] = ['label' => $page->title];
        }
    @endphp

    <x-page-header
        :title="$currentSub ? $page->title : 'Layanan PPID'"
        description="Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau."
        container-class="container mx-auto px-4 max-w-7xl"
        :breadcrumbs="$breadcrumbItems" />
    <div class="py-10 bg-gray-50 min-h-[500px]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-6 relative" x-data="{ activeSection: '' }" @scroll.window="
                let sections = document.querySelectorAll('h2[id], h3[id], h4[id]');
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 150) {
                        current = section.getAttribute('id');
                    }
                });
                activeSection = current;
            ">

                <!-- Content Area -->
                @php
                    $pageContent = $currentSub === 'regulasi'
                        ? \App\Support\PageContent::withoutRegulasiDraftNotice($page->content)
                        : $page->content;
                    $isMaklumatStandarBiaya = \App\Support\PageContent::isMaklumatStandarBiaya($page->slug, $page->title, $currentSub);
                    $extraHeadings = match (true) {
                        $page->slug === 'profile-ppid' => [
                            ['id' => 'waktu-pelayanan', 'text' => 'Waktu Pelayanan'],
                        ],
                        $page->slug === 'struktur-organisasi-ppid-pelaksana-upt' => [
                            ['id' => 'struktur-ppid', 'text' => 'Struktur Organisasi PPID'],
                        ],
                        $currentSub === 'maklumat-pelayanan-standar-biaya' || $page->slug === 'maklumat-pelayanan-dan-standar-biaya' => [
                            ['id' => 'maklumat-pelayanan', 'text' => 'Maklumat Pelayanan'],
                            ['id' => 'standar-biaya', 'text' => 'Standar Biaya'],
                        ],
                        default => [],
                    };
                    $headings = \App\Support\PageContent::headings($pageContent, '234', $extraHeadings, 60);
                    $contentWithIds = \App\Support\PageContent::withHeadingIds($pageContent, '234', 'scroll-mt-32');
                    $showToc = count($headings) > 0;
                @endphp

                <main class="w-full @if($showToc) lg:w-3/4 @endif" x-show="loaded" x-transition:enter="transition-all ease-out duration-500 delay-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    @if($showToc)
                        <div class="lg:hidden mb-4 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ tocOpen: false }">
                            <button type="button" @click="tocOpen = !tocOpen" :aria-expanded="tocOpen.toString()" class="w-full flex justify-between items-center px-5 py-4 font-bold text-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-gold">
                                Daftar Isi
                                <svg class="w-4 h-4 text-text-muted transition-transform" :class="{ 'rotate-180': tocOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <ul x-show="tocOpen" x-collapse class="space-y-1 px-5 pb-4 text-sm">
                                @foreach($headings as $heading)
                                    <li>
                                        <a href="#{{ $heading['id'] }}" @click="tocOpen = false" class="block py-1.5 text-text-muted hover:text-gold focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded">
                                            {{ $heading['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                        @if($currentSub)
                            <h2 class="subsection-title mb-6 scroll-mt-32" @if($page->slug === 'struktur-organisasi-ppid-pelaksana-upt') id="struktur-ppid" @endif>{{ $page->title }}</h2>
                        @endif



                        @if($isMaklumatStandarBiaya)
                            @php
                                preg_match('/href=["\']([^"\']+\.pdf[^"\']*)["\']/i', $pageContent, $pdfMatch);
                                $standardBiayaUrl = $pdfMatch[1] ?? asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
                            @endphp
                            <!-- Section 1: Maklumat Pelayanan -->
                            <div class="mb-12">
                                <h3 id="maklumat-pelayanan" class="text-2xl font-extrabold leading-tight text-navy-dark border-b border-gray-100 pb-2 mb-6 scroll-mt-32">Maklumat Pelayanan</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/maklumat-ppid-page-1.jpg') }}"
                                    alt="Maklumat Pelayanan PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>
                            <!-- Section 2: Standar Biaya -->
                            <div class="mt-16">
                                <h3 id="standar-biaya" class="text-2xl font-extrabold leading-tight text-navy-dark border-b border-gray-100 pb-2 mb-6 scroll-mt-32">Standar Biaya</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/standar-biaya-page-1.jpg') }}"
                                    alt="Standar Biaya Layanan Informasi PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>

                        @elseif(trim(strip_tags($pageContent)) === '' && $page->slug !== 'struktur-organisasi-ppid-pelaksana-upt')
                            <div class="p-12 text-center bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">Belum ada konten</h3>
                                <p class="text-text-muted text-sm">Halaman ini sedang dalam proses pembaruan.</p>
                            </div>
                        @else
                            <div class="prose prose-lg md:prose-xl prose-blue max-w-none prose-headings:font-bold prose-headings:text-navy-dark prose-a:text-blue-600 prose-img:rounded-xl">
                                {!! $contentWithIds !!}

                                @if($page->slug === 'profile-ppid')
                                    <div class="not-prose mt-12 border-t border-gray-100 pt-10">
                                        <h3 id="waktu-pelayanan" class="text-2xl font-extrabold leading-tight text-navy-dark mb-3 scroll-mt-32">Waktu Pelayanan PPID</h3>
                                        <p class="text-text-muted leading-relaxed max-w-3xl mb-6">Informasi waktu pelayanan permohonan informasi publik melalui PPID Pelaksana UPBU Kelas I Kalimarau.</p>
                                        <x-lightbox-image
                                            src="{{ asset('images/ppid/waktu-pelayanan-ppid.jpg') }}"
                                            alt="Waktu Pelayanan PPID Bandar Udara Kalimarau"
                                            figure-class="max-w-3xl mx-auto" />
                                    </div>
                                @endif

                                @if($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                                    <x-page-structure-image type="ppid" :show-heading="false" />
                                @endif
                            </div>
                        @endif
                    </div>
                </main>

                <!-- Table of Contents Sidebar -->
                @if($showToc)
                    <aside class="hidden lg:block lg:w-1/4" x-show="loaded" x-transition:enter="transition-all ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="sticky top-24 bg-gray-100/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-sm">
                            <h4 class="text-sm font-bold text-navy-dark uppercase tracking-wide mb-4">Daftar Isi</h4>
                            <ul class="space-y-3 text-sm">
                                @foreach($headings as $heading)
                                    <li>
                                        <a href="#{{ $heading['id'] }}"
                                           class="block transition-all duration-200 hover:text-gold focus:outline-none focus-visible:ring-2 focus-visible:ring-gold rounded"
                                           :class="activeSection === '{{ $heading['id'] }}' ? 'text-gold font-bold translate-x-1' : 'text-text-muted'">
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

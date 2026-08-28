@php
    if ($page->slug === 'survey-kepuasan-masyarakat-internal') {
        $page->title = 'Survey Kepuasan';
    }
@endphp
<x-layouts.public
    :title="($page->seo_title ?: $page->title) . ' - Bandara Kalimarau'"
    :description="$page->seo_description ?: ($page->excerpt ?: str($page->content)->stripTags()->limit(155)->toString())"
    :canonical="route('pages.show', $page->slug)"
    :image="$page->featured_image_url ?? asset('images/logo-header.png')"
    :robots="($preview ?? false) ? 'noindex, nofollow' : null"
>
    @if($preview ?? false)
        <div class="bg-amber-100 border-b border-amber-300 py-3 text-center text-sm font-medium text-amber-900">Pratinjau admin. Konten ini belum tersedia untuk publik.</div>
    @endif
    <div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => $page->title, 'class' => 'truncate max-w-[200px] md:max-w-md inline-block'],
            ]" />
        </div>
    </div>

    <article class="pt-12 pb-24 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($page->slug !== 'fasilitas-bandara')
                <header class="mb-10 text-center md:text-left">
                    <h1 x-show="loaded"
                        x-transition:enter="transition-all ease-out duration-500 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        style="display: none;"
                        class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6">{{ $page->title }}</h1>

                    <div x-show="loaded"
                         x-transition:enter="transition-all ease-out duration-500 delay-200"
                         x-transition:enter-start="opacity-0 scale-0"
                         x-transition:enter-end="opacity-100 scale-100"
                         style="display: none;"
                         class="h-1.5 w-20 bg-gold-light rounded-full mb-6 mx-auto md:mx-0 origin-left"></div>

                    @if($page->excerpt)
                        <p x-show="loaded"
                           x-transition:enter="transition-all ease-out duration-500 delay-200"
                           x-transition:enter-start="opacity-0 translate-y-4"
                           x-transition:enter-end="opacity-100 translate-y-0"
                           style="display: none;"
                           class="text-xl text-text-muted leading-relaxed">{{ $page->excerpt }}</p>
                    @endif
                </header>

                @if($page->featured_image_url && $page->slug !== 'profil-bandara-kalimarau' && $page->slug !== 'profile-ppid')
                    <figure x-show="loaded"
                            x-transition:enter="transition-all ease-out duration-500 delay-[300ms]"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            style="display: none;"
                            class="mb-12 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm relative group">
                        <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto transition-transform duration-500 group-hover:scale-[1.02]">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl pointer-events-none"></div>
                    </figure>
                @endif
            @endif

            <div x-show="loaded"
                 x-transition:enter="transition-all ease-out duration-500 delay-[400ms]"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;">

            <!-- Content Area with Table of Contents -->
            @php
                $isMaklumatStandarBiaya = \App\Support\PageContent::isMaklumatStandarBiaya($page->slug, $page->title);
                $extraHeadings = match ($page->slug) {
                    'profil-bandara-kalimarau' => [
                        ['id' => 'maklumat-pelayanan', 'text' => 'Maklumat Pelayanan'],
                        ['id' => 'penghargaan-prestasi', 'text' => 'Penghargaan & Prestasi'],
                    ],
                    'struktur-organisasi' => [
                        ['id' => 'struktur-organisasi-bandara-kalimarau', 'text' => 'Struktur Organisasi Bandara Kalimarau'],
                    ],
                    'struktur-organisasi-ppid-pelaksana-upt' => [
                        ['id' => 'struktur-ppid', 'text' => 'Struktur Organisasi PPID'],
                    ],
                    'maklumat-pelayanan-dan-standar-biaya' => [
                        ['id' => 'maklumat-pelayanan', 'text' => 'Maklumat Pelayanan'],
                        ['id' => 'standar-biaya', 'text' => 'Standar Biaya'],
                    ],
                    default => [],
                };
                $headings = \App\Support\PageContent::headings($page->content, '23', $extraHeadings);
                $contentWithIds = \App\Support\PageContent::withHeadingIds($page->content);
            @endphp

            @if($page->slug === 'fasilitas-bandara')
                <!-- Custom Fasilitas Layout -->
                <x-fasilitas-grid />
            @else
                <div class="flex flex-col lg:flex-row lg:items-start gap-12 relative" x-data="{ activeSection: '' }" @scroll.window="
                    let sections = document.querySelectorAll('h2[id]');
                    let current = '';
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop;
                        if (window.scrollY >= sectionTop - 150) {
                            current = section.getAttribute('id');
                        }
                    });
                    activeSection = current;
                ">
                    @php
                        $customPages = ['tarif-kebandarudaraan', 'standar-pelayanan', 'survey-kepuasan-masyarakat-internal', 'simadu', 'sp4n-lapor', 'hasil-dan-tindak-lanjut'];
                        $showToc = count($headings) > 1 && !in_array($page->slug, $customPages);
                    @endphp
                    <!-- Main Content -->
                    <div class="w-full @if($showToc) lg:w-3/4 @endif">
                        @if($isMaklumatStandarBiaya)
                            @include('pages.partials.maklumat-standar-biaya')
                        @else
                            @include(match ($page->slug) {
                                'tarif-kebandarudaraan' => 'pages.partials.tarif-kebandarudaraan',
                                'standar-pelayanan' => 'pages.partials.standar-pelayanan',
                                'survey-kepuasan-masyarakat-internal' => 'pages.partials.survey-kepuasan',
                                'simadu' => 'pages.partials.simadu',
                                'sp4n-lapor' => 'pages.partials.sp4n-lapor',
                                'hasil-dan-tindak-lanjut' => 'pages.partials.hasil-dan-tindak-lanjut',
                                default => 'pages.partials.default-content',
                            })
                        @endif
                    </div>

                    @includeWhen($showToc, 'pages.partials.toc-sidebar')
                </div>
            @endif

            @if($page->slug === 'profil-bandara-kalimarau')
                @include('pages.partials.profil-bandara-extras')
            @endif
            </div>
        </div>
    </article>
</x-layouts.public>

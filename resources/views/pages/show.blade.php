@php
    if ($page->slug === 'survey-kepuasan-masyarakat-internal') {
        $page->title = 'Survey Kepuasan & Hasil Tindak Lanjut';
        $page->excerpt = 'Kanal partisipasi survey kepuasan masyarakat serta publikasi laporan berkala hasil dan tindak lanjut peningkatan mutu pelayanan Bandara Kalimarau.';
    }
    if ($page->slug === 'simadu') {
        $page->title = 'SIMADU - Sistem Manajemen Pengaduan';
        $page->excerpt = 'Layanan terpadu Kementerian Perhubungan untuk menyampaikan laporan, aspirasi, atau pengaduan atas pelayanan publik di Bandara Kalimarau.';
    }
    if ($page->slug === 'sp4n-lapor') {
        $page->title = 'SP4N-LAPOR!';
        $page->excerpt = 'Layanan Aspirasi dan Pengaduan Online Rakyat untuk Pengelolaan Pengaduan Pelayanan Publik Nasional.';
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
    <div class="bg-surface py-4 sm:py-6 border-b border-border-soft">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => $page->title, 'class' => 'truncate max-w-[200px] md:max-w-md inline-block'],
            ]" />
        </div>
    </div>

    <article class="pt-4 md:pt-6 pb-16 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($page->slug !== 'fasilitas-bandara')
                <header class="mb-6 text-center md:text-left">
                    <h1 x-show="loaded"
                        x-cloak
                        x-transition:enter="transition ease-out duration-500 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="font-sans text-2xl md:text-3xl font-extrabold text-navy-dark leading-snug mb-3">{{ $page->title }}</h1>

                    <div x-show="loaded"
                         x-cloak
                         x-transition:enter="transition ease-out duration-500 delay-200"
                         x-transition:enter-start="opacity-0 scale-0"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="h-1.5 w-20 bg-gold-light rounded-full mb-6 mx-auto md:mx-0 origin-left"></div>

                    @if($page->excerpt)
                        <p x-show="loaded"
                           x-cloak
                           x-transition:enter="transition ease-out duration-500 delay-200"
                           x-transition:enter-start="opacity-0 translate-y-4"
                           x-transition:enter-end="opacity-100 translate-y-0"
                           class="text-sm md:text-base text-text-muted leading-relaxed max-w-2xl">{{ $page->excerpt }}</p>
                    @endif
                </header>

                @if($page->featured_image_url && $page->slug !== 'profil-bandara-kalimarau' && $page->slug !== 'profile-ppid')
                    <figure x-show="loaded"
                            x-cloak
                            x-transition:enter="transition ease-out duration-500 delay-300"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="mb-12 rounded-2xl overflow-hidden bg-surface border border-border-soft/70 shadow-sm relative group">
                        <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto transition-transform duration-500 group-hover:scale-[1.02]">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl pointer-events-none"></div>
                    </figure>
                @endif
            @endif

            <div x-show="loaded"
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 delay-400"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 x-transition:enter-end="opacity-100 translate-y-0">

            <!-- Content Area -->
            @php
                $isMaklumatStandarBiaya = \App\Support\PageContent::isMaklumatStandarBiaya($page->slug, $page->title);
                $contentWithIds = \App\Support\PageContent::withHeadingIds($page->content);
            @endphp

            @if($page->slug === 'fasilitas-bandara')
                <!-- Custom Fasilitas Layout -->
                <x-fasilitas-grid />
            @else
                <div class="w-full">
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
            @endif

            @if($page->slug === 'profil-bandara-kalimarau')
                @include('pages.partials.profil-bandara-extras')
            @endif
            </div>
        </div>
    </article>
</x-layouts.public>

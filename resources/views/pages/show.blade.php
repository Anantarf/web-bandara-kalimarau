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
                        x-transition:enter="transition-all ease-out duration-1000 delay-100" 
                        x-transition:enter-start="opacity-0 translate-y-8" 
                        x-transition:enter-end="opacity-100 translate-y-0" 
                        style="display: none;"
                        class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6">{{ $page->title }}</h1>
                    
                    <div x-show="loaded" 
                         x-transition:enter="transition-all ease-out duration-1000 delay-300" 
                         x-transition:enter-start="opacity-0 scale-0" 
                         x-transition:enter-end="opacity-100 scale-100" 
                         style="display: none;"
                         class="h-1.5 w-20 bg-gold-light rounded-full mb-6 mx-auto md:mx-0 origin-left"></div>
                    
                    @if($page->excerpt)
                        <p x-show="loaded" 
                           x-transition:enter="transition-all ease-out duration-1000 delay-500" 
                           x-transition:enter-start="opacity-0 translate-y-4" 
                           x-transition:enter-end="opacity-100 translate-y-0" 
                           style="display: none;"
                           class="text-xl text-gray-500 leading-relaxed">{{ $page->excerpt }}</p>
                    @endif
                </header>

                @if($page->featured_image_url && $page->slug !== 'profil-bandara-kalimarau' && $page->slug !== 'profile-ppid')
                    <figure x-show="loaded" 
                            x-transition:enter="transition-all ease-out duration-1000 delay-[600ms]" 
                            x-transition:enter-start="opacity-0 translate-y-8" 
                            x-transition:enter-end="opacity-100 translate-y-0" 
                            style="display: none;"
                            class="mb-12 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm relative group">
                        <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto transition-transform duration-700 group-hover:scale-[1.02]">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl pointer-events-none"></div>
                    </figure>
                @endif
            @endif

            <div x-show="loaded" 
                 x-transition:enter="transition-all ease-out duration-1000 delay-[700ms]" 
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
                            @php
                                preg_match('/href=["\']([^"\']+\.pdf[^"\']*)["\']/i', $page->content, $pdfMatch);
                                $standardBiayaUrl = $pdfMatch[1] ?? asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
                            @endphp

                            <!-- Section 1: Maklumat Pelayanan -->
                            <div class="mb-12">
                                <h3 id="maklumat-pelayanan" class="text-2xl font-extrabold leading-tight text-navy-dark border-b border-gray-100 pb-2 mb-6 scroll-mt-32">Maklumat Pelayanan</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/maklumat-pelayanan-2026.jpeg') }}"
                                    alt="Maklumat Pelayanan Bandar Udara Kalimarau 2026"
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
                        @elseif($page->slug === 'tarif-kebandarudaraan')
                            <div x-data="{ activeTab: 'aero' }" class="w-full">
                                <p class="text-gray-500 mb-8 text-lg leading-relaxed max-w-3xl">
                                    Informasi resmi mengenai rincian tarif pelayanan jasa kebandarudaraan, baik untuk layanan penerbangan (Aeronautika) maupun layanan penunjang non-penerbangan (Non Aeronautika) di UPBU Kelas I Kalimarau.
                                </p>
                                <div class="flex flex-col sm:flex-row p-1.5 bg-gray-100/80 backdrop-blur-sm rounded-2xl mb-8 border border-gray-200">
                                    <button @click="activeTab = 'aero'" 
                                            :class="activeTab === 'aero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-gray-500 hover:text-navy hover:bg-gray-200/50 border-b-2 border-transparent'"
                                            class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Tarif Aero
                                    </button>
                                    <button @click="activeTab = 'nonaero'" 
                                            :class="activeTab === 'nonaero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-gray-500 hover:text-navy hover:bg-gray-200/50 border-b-2 border-transparent'"
                                            class="flex-1 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition-all duration-200 flex items-center justify-center gap-2 mt-1 sm:mt-0 sm:ml-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Tarif Non Aero
                                    </button>
                                </div>

                                <div class="bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-navy-dark/5 relative">
                                    <div x-show="activeTab === 'aero'"
                                         x-transition:enter="transition ease-out duration-500 delay-100"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="w-full">
                                        <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                            <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                            </div>
                                            <iframe src="https://drive.google.com/file/d/1XsuTFf4z0TyGMer01QT4mX6K5LVmr7S5/preview" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allow="autoplay" allowfullscreen></iframe>
                                        </div>
                                        <a href="https://drive.google.com/file/d/1XsuTFf4z0TyGMer01QT4mX6K5LVmr7S5/view" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                            Dokumen tidak tampil? Buka di tab baru
                                        </a>
                                    </div>

                                    <div x-show="activeTab === 'nonaero'"
                                         style="display: none;"
                                         x-transition:enter="transition ease-out duration-500 delay-100"
                                         x-transition:enter-start="opacity-0 translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="w-full">
                                        <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                            <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                            </div>
                                            <iframe src="https://drive.google.com/file/d/12UDBEDfbWAxBzbsabMvO7wyUjg5luItb/preview" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allow="autoplay" allowfullscreen></iframe>
                                        </div>
                                        <a href="https://drive.google.com/file/d/12UDBEDfbWAxBzbsabMvO7wyUjg5luItb/view" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                            Dokumen tidak tampil? Buka di tab baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->slug === 'standar-pelayanan')
                            <p class="text-gray-500 mb-8 text-lg leading-relaxed max-w-3xl">
                                Dokumen resmi mengenai pedoman operasional, tolak ukur jaminan mutu, serta prosedur standar pelayanan publik yang diselenggarakan oleh Kantor BLU UPBU Kelas I Kalimarau demi kepuasan dan kenyamanan seluruh pengguna jasa bandar udara.
                            </p>
                            <div class="bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-navy-dark/5 relative w-full mb-12">
                                <div x-data="{ loaded: false }" class="aspect-[4/3] md:aspect-[16/10] w-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-inner relative">
                                    <div x-show="!loaded" class="absolute inset-0 flex items-center justify-center">
                                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
                                    </div>
                                    <iframe src="https://docs.google.com/viewer?url={{ urlencode(asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf')) }}&embedded=true" @load="loaded = true" class="absolute inset-0 w-full h-full border-0 relative z-10" allowfullscreen></iframe>
                                </div>
                                <a href="{{ asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-3 text-sm text-navy hover:text-gold-dark font-medium">
                                    Dokumen tidak tampil? Buka di tab baru
                                </a>
                            </div>
                        @elseif($page->slug === 'survey-kepuasan-masyarakat-internal')
                            <div class="space-y-12 w-full mb-12">
                                <!-- Card 1: Survey Kepuasan Masyarakat (Internal) -->
                                <div class="bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-8 md:p-12 border border-gray-100 shadow-xl shadow-navy-dark/5 relative w-full overflow-hidden">
                                    <!-- Decorative Background Elements -->
                                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-gradient-to-br from-gold/10 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-gradient-to-tr from-navy/5 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                    
                                    <div class="relative z-10 flex flex-col lg:flex-row items-start justify-between gap-8 max-w-6xl mx-auto">
                                        <div class="flex-grow text-left">
                                            <div class="w-16 h-16 bg-blue-50 text-navy rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-blue-100 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            </div>
                                            <h3 class="text-2xl md:text-3xl font-bold text-navy-dark mb-4">Survey Kepuasan Pengguna Jasa Internal dan Saran Konsultasi Pengaduan</h3>
                                            <p class="text-gray-500 text-base md:text-lg leading-relaxed">
                                                Kami senantiasa berupaya meningkatkan kualitas layanan di UPBU Kelas I Kalimarau. Ulasan dan masukan Anda sangat berarti bagi kami untuk terus berinovasi dan memberikan pelayanan yang memuaskan.
                                            </p>
                                        </div>
                                        
                                        <!-- Visual Section (Only Poster on desktop) -->
                                        <div class="flex flex-col items-center shrink-0 w-full bg-white p-4 rounded-2xl border border-gray-100 shadow-md lg:mt-0 mt-6" style="width: 100%; max-width: 384px;">
                                            <x-lightbox-image
                                                src="{{ asset('images/survei-internal.jpeg') }}"
                                                alt="Survei Kepuasan Pengguna Jasa Internal"
                                                img-class="w-full object-contain rounded-xl"
                                                figure-class="w-full text-center m-0" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Survey Kepuasan Kementerian Perhubungan -->
                                <div class="bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-8 md:p-12 border border-gray-100 shadow-xl shadow-navy-dark/5 relative w-full overflow-hidden">
                                    <!-- Decorative Background Elements -->
                                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-gradient-to-br from-gold/10 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-gradient-to-tr from-navy/5 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                    
                                    <div class="relative z-10 flex flex-col lg:flex-row items-start justify-between gap-8 max-w-6xl mx-auto">
                                        <div class="flex-grow text-left">
                                            <div class="w-16 h-16 bg-blue-50 text-navy rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-blue-100 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <h3 class="text-2xl md:text-3xl font-bold text-navy-dark mb-4">Survey Kepuasan Masyarakat Kementerian Perhubungan</h3>
                                            <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-4">
                                                Kanal penilaian resmi dari Kementerian Perhubungan untuk mengukur indeks kepuasan masyarakat terhadap kualitas pelayanan jasa transportasi udara di UPBU Kelas I Kalimarau.
                                            </p>
                                        </div>
                                        
                                        <!-- Visual Section (Only Poster on desktop) -->
                                        <div class="flex flex-col items-center shrink-0 w-full bg-white p-4 rounded-2xl border border-gray-100 shadow-md lg:mt-0 mt-6" style="width: 100%; max-width: 384px;">
                                            <x-lightbox-image
                                                src="{{ asset('images/survei-kemenhub.png') }}"
                                                alt="Survey Kepuasan Masyarakat Kementerian Perhubungan"
                                                img-class="w-full object-contain rounded-xl"
                                                figure-class="w-full text-center m-0" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->slug === 'simadu')
                            <div class="bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-navy-dark/5 relative w-full mb-12 overflow-hidden">
                                <!-- Decorative Elements -->
                                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-gradient-to-br from-gold/10 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                
                                <div class="relative z-10 flex flex-col items-center gap-6 md:gap-8">
                                    <!-- Title & Opening Text -->
                                    <div class="w-full text-center max-w-3xl mx-auto">
                                        <h3 class="flex flex-col md:flex-row items-center justify-center gap-3 text-2xl md:text-3xl font-bold text-navy-dark mb-4 leading-tight">
                                            <span>Sistem Manajemen Pengaduan (SIMADU)</span>
                                            <div class="w-10 h-10 bg-blue-50 text-navy rounded-lg flex items-center justify-center shadow-sm border border-blue-100 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                        </h3>
                                        <p class="text-gray-500 text-base md:text-lg leading-relaxed">
                                            Layanan terpadu Kementerian Perhubungan untuk menyampaikan laporan, aspirasi, atau pengaduan atas pelayanan publik. Kami menjamin kerahasiaan identitas Anda sepenuhnya.
                                        </p>
                                    </div>
                                    
                                    <!-- Image -->
                                    <div class="w-full max-w-[760px] mx-auto">
                                        <x-lightbox-image
                                            src="{{ asset('storage/media/legacy/2022/11/4ba95402a5433595324bab5efc0ec308.png') }}"
                                            alt="Alur Tata Cara Pengaduan SIMADU"
                                            figure-class="my-0" />
                                    </div>
                                    
                                    <!-- CTA Button -->
                                    <div class="w-full text-center mt-2">
                                        <a href="https://simadu.dephub.go.id/" target="_blank" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-gold to-gold-light text-white rounded-full font-bold text-lg shadow-lg shadow-gold/30 hover:shadow-xl hover:shadow-gold/40 hover:-translate-y-1 transition-all duration-300 group">
                                            <span>Buat Pengaduan Sekarang</span>
                                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->slug === 'sp4n-lapor')
                            <div class="bg-gradient-to-br from-white via-white to-red-50/30 rounded-3xl p-8 md:p-12 border border-gray-100 shadow-xl shadow-navy-dark/5 relative w-full mb-12 text-center overflow-hidden">
                                <!-- Decorative Background Elements -->
                                <div class="absolute top-0 left-0 -ml-16 -mt-16 w-64 h-64 rounded-full bg-gradient-to-br from-red-500/5 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                <div class="absolute bottom-0 right-0 -mr-16 -mb-16 w-64 h-64 rounded-full bg-gradient-to-tr from-navy/5 to-transparent opacity-50 blur-3xl pointer-events-none"></div>
                                
                                <div class="relative z-10 flex flex-col items-center justify-center max-w-3xl mx-auto">
                                    <div class="w-20 h-20 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm border border-red-100 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                    </div>
                                    <h3 class="text-3xl md:text-4xl font-bold text-navy-dark mb-4 leading-tight">SP4N-LAPOR!</h3>
                                    <h4 class="text-xl md:text-2xl font-semibold text-gray-700 mb-6">Sistem Pengelolaan Pengaduan Pelayanan Publik Nasional</h4>
                                    <p class="text-gray-500 mb-10 text-lg leading-relaxed">
                                        Layanan penyampaian semua aspirasi dan pengaduan rakyat secara dalam jaringan (online) yang terintegrasi. Sampaikan laporan Anda dengan aman, mudah, dan tuntas untuk mewujudkan pelayanan publik yang lebih baik.
                                    </p>
                                    <a href="http://www.lapor.go.id" target="_blank" class="inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-full font-bold text-xl shadow-xl shadow-red-500/30 hover:shadow-2xl hover:shadow-red-500/40 hover:-translate-y-2 transition-all duration-300 group">
                                        <span>Menuju Portal SP4N-LAPOR!</span>
                                        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @elseif($page->slug === 'hasil-dan-tindak-lanjut')
                            <div class="mb-12">
                                <p class="text-gray-500 mb-10 text-lg leading-relaxed max-w-3xl">
                                    Berikut adalah kumpulan dokumen laporan berkala mengenai hasil survei kepuasan masyarakat terhadap pelayanan publik di UPBU Kelas I Kalimarau. Anda dapat mengakses seluruh rincian laporannya melalui tautan di bawah ini:
                                </p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-6">
                                    @php
                                        $dokumenSurvei = [
                                            [
                                                'title' => 'Bulan Agustus 2024',
                                                'link' => 'https://drive.google.com/file/d/168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p/view?usp=sharing',
                                                'id' => '168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p'
                                            ],
                                            [
                                                'title' => 'Bulan Juli 2024',
                                                'link' => 'https://drive.google.com/file/d/1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3/view?usp=sharing',
                                                'id' => '1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3'
                                            ],
                                            [
                                                'title' => 'Bulan Juni 2024',
                                                'link' => 'https://drive.google.com/file/d/1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77/view?usp=sharing',
                                                'id' => '1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77'
                                            ],
                                            [
                                                'title' => 'Bulan Mei 2024',
                                                'link' => 'https://drive.google.com/file/d/1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9/view?usp=sharing',
                                                'id' => '1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9'
                                            ],
                                            [
                                                'title' => 'Bulan April 2024',
                                                'link' => 'https://drive.google.com/file/d/1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_/view?usp=sharing',
                                                'id' => '1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_'
                                            ],
                                            [
                                                'title' => 'Bulan Maret 2024',
                                                'link' => 'https://drive.google.com/file/d/1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP/view?usp=sharing',
                                                'id' => '1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP'
                                            ],
                                            [
                                                'title' => 'Bulan Februari 2024',
                                                'link' => 'https://drive.google.com/file/d/1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q/view?usp=sharing',
                                                'id' => '1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q'
                                            ],
                                            [
                                                'title' => 'Bulan Januari 2024',
                                                'link' => 'https://drive.google.com/file/d/1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213/view?usp=sharing',
                                                'id' => '1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213'
                                            ],
                                        ];
                                    @endphp

                                    @foreach($dokumenSurvei as $doc)
                                        <a href="{{ $doc['link'] }}" target="_blank" class="group flex flex-col bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                            <!-- Thumbnail Section -->
                                            <div class="relative w-full aspect-[3/4] bg-gray-50 flex items-center justify-center overflow-hidden border-b border-gray-100">
                                                <img src="https://drive.google.com/thumbnail?id={{ $doc['id'] }}&sz=w800" 
                                                     alt="Cover Survei {{ $doc['title'] }}"
                                                     class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/600x800/f8fafc/94a3b8?text=Laporan+Survei'; this.className='w-full h-full object-cover opacity-50';"
                                                     loading="lazy">
                                                
                                                <!-- Overlay on hover -->
                                                <div class="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/10 transition-colors duration-300"></div>
                                                
                                                <!-- View Icon overlay -->
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 scale-90 group-hover:scale-100">
                                                    <div class="bg-white/95 backdrop-blur-sm w-14 h-14 rounded-full flex items-center justify-center text-navy-dark shadow-xl">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Content Section -->
                                            <div class="p-6 flex-1 flex flex-col justify-center items-center text-center relative bg-white">
                                                <div class="absolute -top-6 bg-white p-2 rounded-full shadow-sm border border-gray-50">
                                                    <div class="w-10 h-10 bg-gold-light/20 text-gold-dark rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    </div>
                                                </div>
                                                
                                                <h4 class="font-bold text-navy-dark group-hover:text-gold transition-colors duration-300 mb-2 mt-4 leading-snug text-lg">Hasil Survei Kepuasan Masyarakat</h4>
                                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm font-semibold border border-gray-100">
                                                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ $doc['title'] }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="prose prose-lg prose-blue text-gray-800
                                        prose-p:leading-relaxed prose-a:text-sky prose-a:no-underline hover:prose-a:underline
                                        prose-headings:text-navy-dark prose-headings:font-bold
                                        prose-li:marker:text-gold prose-ul:space-y-1">
                                {!! $contentWithIds !!}

                                @if($page->slug === 'struktur-organisasi')
                                    <x-page-structure-image type="airport" />
                                @elseif($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                                    <x-page-structure-image type="ppid" />
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Table of Contents Sidebar -->

                    @if($showToc)
                        <div class="hidden lg:block lg:w-1/4 relative">
                            <div class="sticky top-32 bg-gray-100/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-sm lg:-mt-2">
                                <h4 class="text-sm font-bold text-navy-dark uppercase tracking-wider mb-4">Daftar Isi</h4>
                                <ul class="space-y-3 text-sm">
                                    @foreach($headings as $heading)
                                        <li>
                                            <a href="#{{ $heading['id'] }}" 
                                               class="block transition-colors duration-200 hover:text-gold"
                                               :class="activeSection === '{{ $heading['id'] }}' ? 'text-gold font-bold translate-x-1' : 'text-gray-500'">
                                                {{ $heading['text'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if($page->slug === 'profil-bandara-kalimarau')
                @php
                    $awardImages = collect([
                        'storage/media/legacy/2022/10/20221024_093158-scaled.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100158_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100119_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100043_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100150_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100110_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100051_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100127_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100101_TapScanner-1.jpg',
                    ])->map(fn ($path) => asset($path))->all();
                @endphp
                <div class="mt-16 bg-gradient-to-br from-white via-white to-gold/5 rounded-3xl p-6 md:p-10 border border-gray-100 shadow-xl shadow-navy-dark/5 scroll-mt-32">
                    <div class="text-center mb-10">
                        <h2 id="maklumat-pelayanan" class="text-3xl md:text-4xl font-extrabold text-navy-dark mb-4 scroll-mt-32">Maklumat Pelayanan</h2>
                        <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
                        <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">Komitmen UPBU Kelas I Kalimarau untuk memberikan pelayanan yang transparan, akuntabel, dan sesuai standar mutu bagi seluruh pengguna jasa bandar udara.</p>
                    </div>
                    
                    <x-lightbox-image
                        src="{{ asset('images/maklumat-pelayanan-2026.jpeg') }}"
                        alt="Maklumat Pelayanan Bandar Udara Kalimarau"
                        figure-class="max-w-2xl mx-auto" />

                    <!-- Previous Maklumat Archive Cards -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <!-- Maklumat 2025 -->
                        <a href="{{ asset('images/maklumat-pelayanan-2025.jpeg') }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="group flex items-center justify-between w-full sm:w-80 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold/10 text-gold-dark shadow-sm">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold uppercase tracking-wider text-gold-dark/80">Arsip Maklumat</p>
                                    <h3 class="text-base font-extrabold text-navy-dark group-hover:text-gold transition-colors">Maklumat Pelayanan 2025</h3>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <!-- Maklumat 2023 -->
                        <a href="{{ asset('storage/media/legacy/2023/01/maklumat-pelayanan-2023.jpg') }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="group flex items-center justify-between w-full sm:w-80 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold/10 text-gold-dark shadow-sm">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold uppercase tracking-wider text-gold-dark/80">Arsip Maklumat</p>
                                    <h3 class="text-base font-extrabold text-navy-dark group-hover:text-gold transition-colors">Maklumat Pelayanan 2023</h3>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-16 bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-6 md:p-10 border border-gray-100 shadow-xl shadow-navy-dark/5">
                    <div class="text-center mb-10">
                        <h2 id="penghargaan-prestasi" class="text-3xl md:text-4xl font-extrabold text-navy-dark mb-4 scroll-mt-32">Penghargaan & Prestasi</h2>
                        <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
                        <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">Komitmen UPBU Kalimarau terhadap standar pelayanan prima secara konsisten diwujudkan melalui berbagai pencapaian dan penghargaan bergengsi tingkat nasional.</p>
                    </div>
                    
                    <div class="max-w-4xl mx-auto">
                        <x-carousel :images="$awardImages" />
                    </div>
                </div>
            @endif
            </div>
        </div>
    </article>
</x-layouts.public>

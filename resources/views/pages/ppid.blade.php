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
        :description="$currentSub ? null : 'Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau.'"
        container-class="container mx-auto px-4 max-w-7xl"
        :breadcrumbs="$breadcrumbItems" />
    <div class="pb-12 pt-4 bg-white min-h-[500px]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="w-full relative">

                <!-- Content Area -->
                @php
                    $pageContent = $page->content ?? '';
                    if ($currentSub === 'regulasi') {
                        $pageContent = \App\Support\PageContent::withoutRegulasiDraftNotice($pageContent);
                    }
                    $pageContent = \App\Support\PageContent::withoutDuplicateTitleHeading($pageContent, $page->title, $currentSub);
                    $isMaklumatStandarBiaya = \App\Support\PageContent::isMaklumatStandarBiaya($page->slug, $page->title, $currentSub);
                    $contentWithIds = \App\Support\PageContent::withHeadingIds($pageContent, '234', 'scroll-mt-32');
                @endphp

                <main class="w-full" x-show="loaded" x-cloak x-transition:enter="transition ease-out duration-500 delay-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="w-full">
                        @if($isMaklumatStandarBiaya)
                            @php
                                preg_match('/href=["\']([^"\']+\.pdf[^"\']*)["\']/i', $pageContent, $pdfMatch);
                                $standardBiayaUrl = $pdfMatch[1] ?? asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
                            @endphp
                            <!-- Section 1: Maklumat Pelayanan -->
                            <div class="mb-8">
                                <h3 id="maklumat-pelayanan" class="text-xl md:text-2xl font-extrabold leading-tight text-navy-dark border-b border-border-soft/70 pb-2 mb-4 scroll-mt-32">Maklumat Pelayanan</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/maklumat-ppid-page-1.jpg') }}"
                                    alt="Maklumat Pelayanan PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>
                            <!-- Section 2: Standar Biaya -->
                            <div class="mt-8">
                                <h3 id="standar-biaya" class="text-xl md:text-2xl font-extrabold leading-tight text-navy-dark border-b border-border-soft/70 pb-2 mb-4 scroll-mt-32">Standar Biaya</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/standar-biaya-page-1.jpg') }}"
                                    alt="Standar Biaya Layanan Informasi PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </div>

                        @elseif($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                            <div class="space-y-6">
                                <p class="text-text-main text-base md:text-lg leading-relaxed mb-6">
                                    Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau:
                                </p>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/struktur-ppid.jpeg') }}"
                                    alt="Struktur Organisasi PPID BLU Bandara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto text-center" />
                            </div>

                        @elseif(trim(strip_tags($pageContent)) === '' && $ppidDocuments->isEmpty() && (! $currentSub || ! array_key_exists($currentSub, \App\Models\PpidDocument::CATEGORIES)))
                            <div class="p-8 text-center bg-surface rounded-lg">
                                <svg class="w-12 h-12 text-text-muted/50 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="text-base font-semibold text-text-main mb-1">Belum ada konten</h3>
                                <p class="text-text-muted text-sm">Halaman ini sedang dalam proses pembaruan.</p>
                            </div>
                        @elseif(trim(strip_tags($pageContent)) !== '')
                            <div class="prose prose-lg max-w-none text-text-main prose-p:leading-relaxed prose-a:text-navy hover:prose-a:text-gold-ink font-medium prose-a:no-underline hover:prose-a:underline prose-headings:text-navy-dark prose-headings:font-bold prose-li:marker:text-gold prose-ul:space-y-1">
                                {!! $contentWithIds !!}

                                @if($page->slug === 'profile-ppid')
                                    <!-- Visi & Misi Section -->
                                    <div id="visi-misi" class="not-prose mt-8 border-t border-border-soft/70 pt-6 scroll-mt-32">
                                        <div class="flex items-center gap-2.5 mb-4">
                                            <div class="w-1.5 h-6 bg-gold rounded-full"></div>
                                            <h3 class="text-xl md:text-2xl font-extrabold text-navy-dark">Visi & Misi PPID</h3>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <!-- Visi Card -->
                                            <div class="bg-surface/80 hover:bg-surface rounded-xl p-5 border border-border-soft transition-colors duration-200">
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gold/10 text-gold-ink mb-3">
                                                    VISI PPID
                                                </div>
                                                <p class="text-sm md:text-base text-text-main leading-relaxed font-medium">
                                                    "Terwujudnya pelayanan informasi publik yang transparan, efektif, efisien, dan dapat dipertanggungjawabkan di lingkungan BLU UPBU Kelas I Kalimarau."
                                                </p>
                                            </div>

                                            <!-- Misi Card -->
                                            <div class="bg-surface/80 hover:bg-surface rounded-xl p-5 border border-border-soft transition-colors duration-200">
                                                <div>
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-navy/10 text-navy mb-3">
                                                        MISI PPID
                                                    </div>
                                                    <ul class="space-y-3 text-sm md:text-base text-text-main">
                                                        <li class="flex items-start gap-2.5">
                                                            <svg class="w-5 h-5 text-gold shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                            <span>Meningkatkan pengelolaan & dokumentasi informasi publik secara profesional.</span>
                                                        </li>
                                                        <li class="flex items-start gap-2.5">
                                                            <svg class="w-5 h-5 text-gold shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                            <span>Mempermudah akses permohonan informasi publik bagi masyarakat luas.</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tugas & Fungsi Section -->
                                    <div id="tugas-dan-fungsi" class="not-prose mt-8 border-t border-border-soft/70 pt-6 scroll-mt-32">
                                        <div class="flex items-center gap-2.5 mb-3">
                                            <div class="w-1.5 h-6 bg-gold rounded-full"></div>
                                            <h3 class="text-xl md:text-2xl font-extrabold text-navy-dark">Tugas & Fungsi PPID</h3>
                                        </div>

                                        <p class="text-text-muted leading-relaxed mb-5 text-base">
                                            Sesuai dengan Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik, PPID UPBU Kelas I Kalimarau menjalankan tugas dan fungsi utama sebagai berikut:
                                        </p>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
                                            <div class="p-5 bg-surface/80 hover:bg-surface surface-card p-5 transition-colors duration-200 flex items-start gap-4">
                                                <div class="w-9 h-9 rounded-xl bg-navy-dark text-gold font-extrabold flex items-center justify-center shrink-0 text-sm shadow-sm">1</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pengelolaan Informasi</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Mengumpulkan dan mengklasifikasikan dokumen serta informasi publik berkala dan serta-merta.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 bg-surface/80 hover:bg-surface surface-card p-5 transition-colors duration-200 flex items-start gap-4">
                                                <div class="w-9 h-9 rounded-xl bg-navy-dark text-gold font-extrabold flex items-center justify-center shrink-0 text-sm shadow-sm">2</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pelayanan Permohonan</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Melayani permohonan informasi publik secara efisien, transparan, dan tepat waktu.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 bg-surface/80 hover:bg-surface surface-card p-5 transition-colors duration-200 flex items-start gap-4">
                                                <div class="w-9 h-9 rounded-xl bg-navy-dark text-gold font-extrabold flex items-center justify-center shrink-0 text-sm shadow-sm">3</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pengujian Konsekuensi</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Melakukan pengujian konsekuensi atas informasi yang dikecualikan secara cermat.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 bg-surface/80 hover:bg-surface surface-card p-5 transition-colors duration-200 flex items-start gap-4">
                                                <div class="w-9 h-9 rounded-xl bg-navy-dark text-gold font-extrabold flex items-center justify-center shrink-0 text-sm shadow-sm">4</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Dokumentasi & Arsip</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Menyimpan dan merawat arsip informasi publik agar selalu dapat diakses sesuai prosedur.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Waktu Pelayanan Section -->
                                    <div class="not-prose mt-8 border-t border-border-soft/70 pt-6">
                                        <div class="flex items-center gap-2.5 mb-4">
                                            <div class="w-1.5 h-6 bg-gold rounded-full"></div>
                                            <h3 id="waktu-pelayanan" class="text-xl md:text-2xl font-extrabold text-navy-dark scroll-mt-32">Waktu Pelayanan PPID</h3>
                                        </div>
                                        <p class="text-text-muted leading-relaxed max-w-3xl mb-4 text-base">Informasi waktu pelayanan permohonan informasi publik melalui PPID Pelaksana UPBU Kelas I Kalimarau:</p>
                                        <x-lightbox-image
                                            src="{{ asset('images/ppid/waktu-pelayanan-ppid.jpg') }}"
                                            alt="Waktu Pelayanan PPID Bandar Udara Kalimarau"
                                            figure-class="not-prose max-w-2xl mx-auto" />
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($ppidDocuments->isNotEmpty())
                            <div class="not-prose @if(trim(strip_tags($pageContent)) !== '') mt-10 border-t border-border-soft/70 pt-8 @else mt-0 @endif">
                                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-5">
                                    <div>
                                        <h3 class="text-xl md:text-2xl font-extrabold text-navy-dark">Dokumen {{ $page->title }}</h3>
                                        <p class="text-sm text-text-muted mt-1">Dokumen resmi PPID yang dapat dilihat atau diakses publik.</p>
                                    </div>
                                </div>

                                <div class="divide-y divide-border-soft/70 border border-border-soft rounded-xl bg-white overflow-hidden">
                                    @foreach($ppidDocuments as $document)
                                        <article class="p-5 md:p-6 hover:bg-surface transition-colors">
                                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                                        <span class="inline-flex items-center rounded-full bg-gold/10 px-3 py-1 text-xs font-bold text-gold-ink">{{ $document->category_label }}</span>
                                                        @if($document->published_at)
                                                            <span class="text-xs text-text-muted">{{ $document->published_at->translatedFormat('d F Y') }}</span>
                                                        @endif
                                                    </div>
                                                    <h4 class="text-lg font-bold text-navy-dark leading-snug">{{ $document->title }}</h4>
                                                    @if($document->description)
                                                        <p class="text-sm md:text-base text-text-muted leading-relaxed mt-2">{{ $document->description }}</p>
                                                    @endif
                                                </div>
                                                <a href="{{ $document->file_url }}" target="_blank" rel="noopener" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-navy px-4 py-2.5 min-h-[44px] min-w-[44px] text-sm font-bold text-white hover:bg-navy-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 transition-colors">
                                                    <svg class="w-4 h-4 text-gold-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <span>View Dokumen</span>
                                                </a>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($currentSub && array_key_exists($currentSub, \App\Models\PpidDocument::CATEGORIES))
                            <div class="not-prose mt-10 border-t border-border-soft/70 pt-8">
                                <div class="rounded-xl border border-dashed border-border-soft bg-surface p-6 text-center">
                                    <h3 class="text-base font-bold text-navy-dark">Belum ada dokumen PPID yang tersedia.</h3>
                                    <p class="text-sm text-text-muted mt-1">Dokumen untuk kategori ini akan tampil setelah dipublikasikan melalui CMS.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-layouts.public>

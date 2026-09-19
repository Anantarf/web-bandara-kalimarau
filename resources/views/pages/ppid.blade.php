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

        $ppidSidebarGroups = [
            'PPID' => [
                ['label' => 'Profil PPID', 'sub' => 'profil'],
                ['label' => 'Struktur Organisasi', 'sub' => 'struktur-organisasi'],
                ['label' => 'Regulasi PPID', 'sub' => 'regulasi'],
            ],
            'Informasi Publik' => [
                ['label' => 'Informasi Berkala', 'sub' => 'informasi-berkala'],
                ['label' => 'Informasi Setiap Saat', 'sub' => 'informasi-setiap-saat'],
                ['label' => 'Informasi Serta Merta', 'sub' => 'informasi-serta-merta'],
            ],
            'Layanan Informasi' => [
                ['label' => 'Maklumat & Standar Biaya', 'sub' => 'maklumat-pelayanan-standar-biaya'],
                ['label' => 'Prosedur Permohonan', 'sub' => 'prosedur-permohonan-informasi'],
                ['label' => 'Prosedur Keberatan', 'sub' => 'prosedur-keberatan-informasi'],
            ],
        ];
    @endphp

    <x-page-header
        :title="$currentSub ? $page->title : 'Layanan PPID'"
        :description="$currentSub ? ($page->excerpt ?: strip_tags($page->content ?? '')) : 'Pejabat Pengelola Informasi dan Dokumentasi UPBU Kelas I Kalimarau.'"
        container-class="container mx-auto px-4 max-w-7xl"
        header-class="py-5 md:py-7 bg-white"
        :breadcrumbs="$breadcrumbItems" />
    <div class="pb-12 pt-0 bg-white min-h-[500px]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid gap-6 lg:grid-cols-[15.5rem_minmax(0,1fr)] lg:items-start">
                <aside class="lg:sticky lg:top-24">
                    <nav class="rounded-lg border border-border-soft bg-surface/80 p-3" aria-label="Kategori informasi PPID">
                        <a href="{{ route('ppid.show') }}" class="mb-3 flex items-center justify-between rounded-md px-3 py-2 text-sm font-bold transition-colors {{ $currentSub ? 'text-navy hover:bg-white' : 'bg-navy text-white' }}">
                            <span>Layanan PPID</span>
                            <span class="text-xs {{ $currentSub ? 'text-text-muted' : 'text-gold-light' }}">Beranda</span>
                        </a>

                        <div class="space-y-4">
                            @foreach($ppidSidebarGroups as $groupLabel => $items)
                                <section>
                                    <h2 class="px-3 text-[11px] font-extrabold text-text-muted">{{ $groupLabel }}</h2>
                                    <div class="mt-1.5 space-y-0.5">
                                        @foreach($items as $item)
                                            <a href="{{ route('ppid.show', $item['sub']) }}"
                                               class="block rounded-md px-3 py-1.5 text-sm font-semibold transition-colors {{ $currentSub === $item['sub'] ? 'bg-white text-navy shadow-sm ring-1 ring-border-soft' : 'text-text-main hover:bg-white hover:text-navy' }}">
                                                {{ $item['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    </nav>
                </aside>

                <!-- Content Area -->
                @php
                    $pageContent = $page->content ?? '';
                    if ($currentSub === 'regulasi') {
                        $pageContent = \App\Support\PageContent::withoutRegulasiDraftNotice($pageContent);
                    }
                    $pageContent = \App\Support\PageContent::withoutDuplicateTitleHeading($pageContent, $page->title, $currentSub);
                    $pageContent = \App\Support\HtmlSanitizer::clean($pageContent);
                    $plainPageContent = trim(preg_replace('/\s+/', ' ', strip_tags($pageContent)));
                    $plainExcerpt = trim(preg_replace('/\s+/', ' ', $page->excerpt ?? ''));
                    if ($currentSub && $plainExcerpt !== '' && $plainPageContent === $plainExcerpt) {
                        $pageContent = '';
                    }
                    $isMaklumatStandarBiaya = \App\Support\PageContent::isMaklumatStandarBiaya($page->slug, $page->title, $currentSub);
                    $contentWithIds = \App\Support\PageContent::withHeadingIds($pageContent, '234', 'scroll-mt-32');
                @endphp

                <main class="w-full min-w-0" x-show="loaded" x-cloak x-transition:enter="transition ease-out duration-300 delay-150" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="w-full space-y-8">
                        @if($isMaklumatStandarBiaya)
                            @php
                                preg_match('/href=["\']([^"\']+\.pdf[^"\']*)["\']/i', $pageContent, $pdfMatch);
                                $standardBiayaUrl = $pdfMatch[1] ?? asset('storage/media/legacy/2024/09/Standar-Pelayanan-2023.pdf');
                            @endphp
                            <!-- Section 1: Maklumat Pelayanan -->
                            <section class="rounded-lg border border-border-soft bg-white p-5 md:p-6">
                                <h3 id="maklumat-pelayanan" class="text-xl md:text-2xl font-extrabold leading-tight text-navy-dark border-b border-border-soft/70 pb-2 mb-4 scroll-mt-32">Maklumat Pelayanan</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/maklumat-ppid-page-1.jpg') }}"
                                    alt="Maklumat Pelayanan PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </section>
                            <!-- Section 2: Standar Biaya -->
                            <section class="rounded-lg border border-border-soft bg-white p-5 md:p-6">
                                <h3 id="standar-biaya" class="text-xl md:text-2xl font-extrabold leading-tight text-navy-dark border-b border-border-soft/70 pb-2 mb-4 scroll-mt-32">Standar Biaya</h3>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/standar-biaya-page-1.jpg') }}"
                                    alt="Standar Biaya Layanan Informasi PPID Bandar Udara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto" />
                            </section>

                        @elseif($page->slug === 'struktur-organisasi-ppid-pelaksana-upt')
                            <section class="rounded-lg border border-border-soft bg-white p-5 md:p-6 space-y-6">
                                <p class="text-text-main text-base md:text-lg leading-relaxed mb-6">
                                    Berikut adalah bagan susunan Struktur Organisasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Badan Layanan Umum (BLU) Kantor Unit Penyelenggara Bandar Udara Kelas I Kalimarau:
                                </p>
                                <x-lightbox-image
                                    src="{{ asset('images/ppid/struktur-ppid.jpeg') }}"
                                    alt="Struktur Organisasi PPID BLU Bandara Kalimarau"
                                    figure-class="not-prose max-w-2xl mx-auto text-center" />
                            </section>

                        @elseif(trim(strip_tags($pageContent)) === '' && $ppidDocuments->isEmpty() && (! $currentSub || ! array_key_exists($currentSub, \App\Models\PpidDocument::CATEGORIES)))
                            <section class="rounded-lg border border-border-soft bg-surface p-8 text-center">
                                <svg class="w-12 h-12 text-text-muted/50 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <h3 class="text-base font-semibold text-text-main mb-1">Belum ada konten</h3>
                                <p class="text-text-muted text-sm">Halaman ini sedang dalam proses pembaruan.</p>
                            </section>
                        @elseif(trim(strip_tags($pageContent)) !== '')
                            <section class="rounded-lg border border-border-soft bg-white p-5 md:p-6">
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
                                            <div class="rounded-lg p-5 border border-border-soft bg-surface/40">
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gold/10 text-gold-ink mb-3 ">
                                                    VISI PPID
                                                </div>
                                                <p class="text-sm md:text-base text-text-main leading-relaxed font-medium">
                                                    "Terwujudnya pelayanan informasi publik yang transparan, efektif, efisien, dan dapat dipertanggungjawabkan di lingkungan BLU UPBU Kelas I Kalimarau."
                                                </p>
                                            </div>

                                            <!-- Misi Card -->
                                            <div class="rounded-lg p-5 border border-border-soft bg-surface/40">
                                                <div>
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-navy/10 text-navy mb-3 ">
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
                                            <div class="p-5 rounded-lg border border-border-soft bg-surface/40 flex items-start gap-4">
                                                <div class="w-8 h-8 rounded-md bg-navy text-white font-extrabold flex items-center justify-center shrink-0 text-sm">1</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pengelolaan Informasi</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Mengumpulkan dan mengklasifikasikan dokumen serta informasi publik berkala dan serta-merta.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 rounded-lg border border-border-soft bg-surface/40 flex items-start gap-4">
                                                <div class="w-8 h-8 rounded-md bg-navy text-white font-extrabold flex items-center justify-center shrink-0 text-sm">2</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pelayanan Permohonan</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Melayani permohonan informasi publik secara efisien, transparan, dan tepat waktu.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 rounded-lg border border-border-soft bg-surface/40 flex items-start gap-4">
                                                <div class="w-8 h-8 rounded-md bg-navy text-white font-extrabold flex items-center justify-center shrink-0 text-sm">3</div>
                                                <div>
                                                    <h4 class="font-extrabold text-navy-dark text-base mb-1">Pengujian Konsekuensi</h4>
                                                    <p class="text-sm text-text-muted leading-relaxed">Melakukan pengujian konsekuensi atas informasi yang dikecualikan secara cermat.</p>
                                                </div>
                                            </div>

                                            <div class="p-5 rounded-lg border border-border-soft bg-surface/40 flex items-start gap-4">
                                                <div class="w-8 h-8 rounded-md bg-navy text-white font-extrabold flex items-center justify-center shrink-0 text-sm">4</div>
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

                            </section>
                        @endif

                        @if($ppidDocuments->isNotEmpty())
                            <div class="not-prose @if(trim(strip_tags($pageContent)) !== '') mt-0 @else mt-0 @endif" x-data="{ query: '' }">
                                <div class="flex flex-col gap-4 border-b border-border-soft pb-5 md:flex-row md:items-end md:justify-between">
                                    <div>
                                        <h3 class="text-xl font-extrabold text-navy-dark md:text-2xl">Dokumen {{ $page->title }}</h3>
                                        <p class="mt-1 text-sm text-text-muted">Daftar berkas informasi publik yang dapat dilihat atau diunduh.</p>
                                    </div>
                                    <label class="relative block w-full md:max-w-xs">
                                        <span class="sr-only">Cari dokumen</span>
                                        <input type="search"
                                               x-model="query"
                                               placeholder="Cari dokumen..."
                                               class="w-full rounded-lg border border-border-soft bg-white px-4 py-2.5 pr-10 text-sm font-semibold text-text-main placeholder:text-text-muted focus:border-navy focus:outline-none focus:ring-2 focus:ring-gold/40">
                                        <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                                    </label>
                                </div>

                                <div class="mt-5 overflow-hidden rounded-lg border border-border-soft bg-white">
                                    <div class="hidden grid-cols-[minmax(0,1fr)_6rem_8rem_7rem] gap-4 bg-surface px-5 py-3 text-xs font-extrabold text-text-muted md:grid">
                                        <span>Daftar berkas informasi publik</span>
                                        <span>Tipe</span>
                                        <span>Tanggal</span>
                                        <span class="text-right">Aksi</span>
                                    </div>

                                    <div class="divide-y divide-border-soft/70">
                                        @foreach($ppidDocuments as $document)
                                            @php
                                                $extension = $document->external_url
                                                    ? 'link'
                                                    : (pathinfo((string) $document->file_path, PATHINFO_EXTENSION) ?: 'file');
                                                $publishedLabel = $document->published_at?->translatedFormat('d M Y') ?? '-';
                                            @endphp
                                            <article x-show="! query || '{{ e(\Illuminate\Support\Str::lower($document->title.' '.$document->description.' '.$document->category_label)) }}'.includes(query.toLowerCase())"
                                                     class="grid gap-4 px-5 py-4 transition-colors hover:bg-surface md:grid-cols-[minmax(0,1fr)_6rem_8rem_7rem] md:items-center">
                                                <div class="min-w-0">
                                                    <h4 class="text-base font-extrabold leading-snug text-navy-dark">{{ $document->title }}</h4>
                                                    @if($document->description)
                                                        <p class="mt-1 max-w-3xl text-sm leading-relaxed text-text-muted">{{ $document->description }}</p>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="inline-flex rounded-full bg-navy/10 px-2.5 py-1 text-xs font-extrabold uppercase text-navy">{{ $extension }}</span>
                                                </div>
                                                <div class="text-sm font-semibold text-text-muted">{{ $publishedLabel }}</div>
                                                <div class="md:text-right">
                                                    <a href="{{ $document->file_url }}" target="_blank" rel="noopener" class="inline-flex min-h-11 w-full items-center justify-center rounded-lg bg-navy px-4 py-2 text-sm font-extrabold text-white transition-colors hover:bg-navy-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 md:w-auto">
                                                        Unduh
                                                    </a>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif($currentSub && array_key_exists($currentSub, \App\Models\PpidDocument::CATEGORIES))
                            <div class="not-prose mt-10 border-t border-border-soft/70 pt-8">
                                <div class="rounded-xl border border-dashed border-border-soft bg-surface p-6 text-center">
                                    <h3 class="text-base font-bold text-navy-dark">Belum ada dokumen PPID yang tersedia.</h3>
                                    <p class="mt-1 text-sm text-text-muted">Dokumen untuk kategori ini akan tampil setelah dipublikasikan melalui CMS.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-layouts.public>

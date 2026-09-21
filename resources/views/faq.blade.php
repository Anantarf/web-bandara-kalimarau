<x-layouts.public
    title="FAQ Lengkap - Bandara Kalimarau"
    description="Pertanyaan yang Sering Diajukan Seputar Bandara Kalimarau."
    :withHeaderPadding="true"
>
    <x-page-header
        title="Pertanyaan yang Sering Diajukan (FAQ)"
        description="Temukan jawaban cepat untuk berbagai pertanyaan seputar layanan, fasilitas, dan prosedur di Bandara Kalimarau."
        container-class="max-w-4xl mx-auto px-4"
        align="center"
        header-class="py-6 md:py-8 bg-white"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Informasi'],
            ['label' => 'FAQ Lengkap'],
        ]" />

    <!-- FAQ Content Section -->
    <section class="bg-white pb-12">
        <div class="max-w-4xl mx-auto px-4" x-data="{ activeAccordion: null, searchQuery: '', loaded: true }">

            <!-- Live Search Bar -->
            <div class="mb-8 relative max-w-2xl mx-auto"
                 x-show="loaded" x-cloak
                 x-transition:enter="transition ease-out duration-300 delay-150"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 >
                <label for="faq-search" class="sr-only">Cari pertanyaan FAQ</label>
                <input id="faq-search" type="search" x-model="searchQuery" placeholder="Cari pertanyaan atau kata kunci..."
                       class="w-full bg-white border border-border-soft rounded-xl py-3.5 pl-14 pr-6 text-navy focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition shadow-sm font-medium">
                <svg class="w-6 h-6 text-text-muted/70 absolute left-5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Category: Persiapan Keberangkatan -->
            <h2 class="text-xl md:text-2xl font-extrabold text-navy-dark mb-4 mt-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Persiapan Keberangkatan
            </h2>
            <div class="space-y-4">
                @php
                    $faqsCategory1 = [
                        ['q' => 'Berapa jam sebelum keberangkatan saya harus tiba di bandara?', 'a' => 'Untuk penerbangan domestik, kami menyarankan Anda tiba di bandara minimal 2 jam sebelum waktu keberangkatan. Untuk penerbangan internasional, disarankan tiba minimal 3 jam sebelum waktu keberangkatan.'],
                        ['q' => 'Apakah saya perlu mencetak tiket?', 'a' => 'Tidak wajib. Anda dapat menunjukkan e-ticket (tiket elektronik) melalui smartphone Anda di konter check-in atau langsung di area pemeriksaan keamanan jika sudah melakukan web check-in.'],
                        ['q' => 'Dokumen apa saja yang harus disiapkan?', 'a' => 'Siapkan tiket pesawat (fisik/elektronik) dan kartu identitas diri yang sah dan masih berlaku (KTP, SIM, atau Paspor).'],
                    ];
                @endphp
                @foreach($faqsCategory1 as $index => $faq)
                    <div class="surface-card overflow-hidden"
                         x-show="searchQuery === '' || '{{ strtolower(addslashes($faq['q'] . ' ' . $faq['a'])) }}'.includes(searchQuery.toLowerCase())">
                        <button id="faq-question-cat1_{{ $index }}" @click="activeAccordion = activeAccordion === 'cat1_{{ $index }}' ? null : 'cat1_{{ $index }}'" :aria-expanded="(activeAccordion === 'cat1_{{ $index }}').toString()" aria-controls="faq-answer-cat1_{{ $index }}"
                                class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none focus-visible:ring-2 focus-visible:ring-gold relative">
                            <span class="font-bold text-navy-dark text-base md:text-lg">{{ $faq['q'] }}</span>
                            <span class="bg-surface rounded-full p-2 transition-transform duration-200"
                                  :class="activeAccordion === 'cat1_{{ $index }}' ? 'rotate-180 bg-gold/10 text-gold' : 'text-text-muted/70'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div id="faq-answer-cat1_{{ $index }}" x-show="activeAccordion === 'cat1_{{ $index }}'" x-cloak x-collapse role="region" aria-labelledby="faq-question-cat1_{{ $index }}">
                            <div class="px-6 pb-6 pt-2 text-text-muted leading-relaxed border-t border-border-soft/70 text-sm md:text-base">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Category: Fasilitas & Layanan -->
            <h2 class="text-xl md:text-2xl font-extrabold text-navy-dark mb-4 mt-8 flex items-center gap-2">
                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Fasilitas & Layanan
            </h2>
            <div class="space-y-4">
                @php
                    $faqsCategory2 = [
                        ['q' => 'Apakah Bandara Kalimarau menyediakan fasilitas kursi roda?', 'a' => 'Ya, kami menyediakan fasilitas kursi roda secara gratis. Anda dapat memintanya kepada petugas customer service atau maskapai penerbangan Anda sebelum jadwal keberangkatan.'],
                        ['q' => 'Di mana lokasi ruang laktasi (ruang menyusui)?', 'a' => 'Ruang laktasi tersedia di area ruang tunggu keberangkatan, berdekatan dengan toilet wanita. Ruangan ini dilengkapi dengan fasilitas yang nyaman dan privasi.'],
                        ['q' => 'Apakah tersedia area merokok di dalam bandara?', 'a' => 'Area merokok (Smoking Lounge) tersedia di area khusus di luar gedung terminal dan di area ruang tunggu (setelah melewati security check) di ruangan yang telah ditentukan.'],
                    ];
                @endphp
                @foreach($faqsCategory2 as $index => $faq)
                    <div class="surface-card overflow-hidden"
                         x-show="searchQuery === '' || '{{ strtolower(addslashes($faq['q'] . ' ' . $faq['a'])) }}'.includes(searchQuery.toLowerCase())">
                        <button id="faq-question-cat2_{{ $index }}" @click="activeAccordion = activeAccordion === 'cat2_{{ $index }}' ? null : 'cat2_{{ $index }}'" :aria-expanded="(activeAccordion === 'cat2_{{ $index }}').toString()" aria-controls="faq-answer-cat2_{{ $index }}"
                                class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none focus-visible:ring-2 focus-visible:ring-gold relative">
                            <span class="font-bold text-navy-dark text-base md:text-lg">{{ $faq['q'] }}</span>
                            <span class="bg-surface rounded-full p-2 transition-transform duration-200"
                                  :class="activeAccordion === 'cat2_{{ $index }}' ? 'rotate-180 bg-gold/10 text-gold' : 'text-text-muted/70'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div id="faq-answer-cat2_{{ $index }}" x-show="activeAccordion === 'cat2_{{ $index }}'" x-cloak x-collapse role="region" aria-labelledby="faq-question-cat2_{{ $index }}">
                            <div class="px-6 pb-6 pt-2 text-text-muted leading-relaxed border-t border-border-soft/70 text-sm md:text-base">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @php
                $faqJsonLd = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => collect($faqsCategory1)->concat($faqsCategory2)->map(fn ($faq) => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['a'],
                        ],
                    ])->all(),
                ];
            @endphp
            <script type="application/ld+json">{!! json_encode($faqJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

            <!-- CTA Section -->
            <div class="mt-10 text-center surface-card p-6 md:p-8 shadow-sm">
                <div class="w-16 h-16 bg-gold/10 rounded-full flex items-center justify-center mx-auto mb-4 text-gold-ink">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy-dark mb-2">Punya pertanyaan lain?</h3>
                <p class="text-text-muted mb-6">Tim layanan pelanggan kami siap membantu Anda 24/7.</p>
                <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center bg-navy hover:bg-navy-dark text-white px-8 py-3 rounded-full font-bold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2">
                    Hubungi Kami
                </a>
            </div>

        </div>
    </section>
</x-layouts.public>

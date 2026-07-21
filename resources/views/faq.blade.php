<x-layouts.public
    title="FAQ Lengkap - Bandara Kalimarau"
    description="Pertanyaan yang Sering Diajukan Seputar Bandara Kalimarau."
    :withHeaderPadding="true"
>
    <!-- Breadcrumb (Golden Standard) -->
    <div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <nav class="flex text-sm font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-500 hover:text-navy transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 md:ml-2 text-gray-500">Informasi</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 md:ml-2 text-gray-800 font-bold">FAQ Lengkap</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header Section (Golden Standard) -->
    <section class="bg-white pt-16 pb-12" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-4"
                x-show="loaded"
                x-transition:enter="transition-all ease-out duration-1000"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h1>
            
            <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"
                 x-show="loaded"
                 x-transition:enter="transition-all ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 scale-x-0"
                 x-transition:enter-end="opacity-100 scale-x-100"
                 style="display: none;"></div>
                 
            <p class="text-lg text-gray-500 text-pretty max-w-2xl mx-auto"
               x-show="loaded"
               x-transition:enter="transition-all ease-out duration-1000 delay-500"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               style="display: none;">
                Temukan jawaban cepat untuk berbagai pertanyaan seputar layanan, fasilitas, dan prosedur di Bandara Kalimarau.
            </p>
        </div>
    </section>

    <!-- FAQ Content Section -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4" x-data="{ activeAccordion: null, searchQuery: '' }">
            
            <!-- Live Search Bar -->
            <div class="mb-12 relative max-w-2xl mx-auto"
                 x-show="loaded"
                 x-transition:enter="transition-all ease-out duration-1000 delay-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;">
                <input type="text" x-model="searchQuery" placeholder="Cari pertanyaan atau kata kunci..." 
                       class="w-full bg-white border-2 border-gray-100 rounded-full py-4 pl-14 pr-6 text-navy focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all shadow-sm font-medium">
                <svg class="w-6 h-6 text-gray-400 absolute left-5 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <!-- Category: Persiapan Keberangkatan -->
            <h2 class="text-2xl font-bold text-navy-dark mb-6 mt-8 flex items-center gap-2">
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md"
                         x-show="searchQuery === '' || '{{ strtolower(addslashes($faq['q'] . ' ' . $faq['a'])) }}'.includes(searchQuery.toLowerCase())">
                        <button @click="activeAccordion = activeAccordion === 'cat1_{{ $index }}' ? null : 'cat1_{{ $index }}'" 
                                class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none relative">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gold transition-transform duration-300 transform origin-left"
                                 :class="activeAccordion === 'cat1_{{ $index }}' ? 'scale-y-100' : 'scale-y-0'"></div>
                            <span class="font-bold text-navy-dark text-lg" :class="activeAccordion === 'cat1_{{ $index }}' ? 'text-gold' : ''">{{ $faq['q'] }}</span>
                            <span class="bg-gray-50 rounded-full p-2 transition-transform duration-300" 
                                  :class="activeAccordion === 'cat1_{{ $index }}' ? 'rotate-180 bg-gold/10 text-gold' : 'text-gray-400'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeAccordion === 'cat1_{{ $index }}'" x-collapse>
                            <div class="px-6 pb-6 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Category: Fasilitas & Layanan -->
            <h2 class="text-2xl font-bold text-navy-dark mb-6 mt-12 flex items-center gap-2">
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md"
                         x-show="searchQuery === '' || '{{ strtolower(addslashes($faq['q'] . ' ' . $faq['a'])) }}'.includes(searchQuery.toLowerCase())">
                        <button @click="activeAccordion = activeAccordion === 'cat2_{{ $index }}' ? null : 'cat2_{{ $index }}'" 
                                class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none relative">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gold transition-transform duration-300 transform origin-left"
                                 :class="activeAccordion === 'cat2_{{ $index }}' ? 'scale-y-100' : 'scale-y-0'"></div>
                            <span class="font-bold text-navy-dark text-lg" :class="activeAccordion === 'cat2_{{ $index }}' ? 'text-gold' : ''">{{ $faq['q'] }}</span>
                            <span class="bg-gray-50 rounded-full p-2 transition-transform duration-300" 
                                  :class="activeAccordion === 'cat2_{{ $index }}' ? 'rotate-180 bg-gold/10 text-gold' : 'text-gray-400'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeAccordion === 'cat2_{{ $index }}'" x-collapse>
                            <div class="px-6 pb-6 pt-2 text-gray-600 leading-relaxed border-t border-gray-50">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- CTA Section -->
            <div class="mt-16 text-center bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-sky">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy-dark mb-2">Punya pertanyaan lain?</h3>
                <p class="text-gray-500 mb-6">Tim layanan pelanggan kami siap membantu Anda 24/7.</p>
                <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center bg-navy hover:bg-navy-dark text-white px-8 py-3 rounded-full font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-1">
                    Hubungi Kami
                </a>
            </div>

        </div>
    </section>
</x-layouts.public>

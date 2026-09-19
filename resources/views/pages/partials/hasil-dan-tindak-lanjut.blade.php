<div class="mb-8">
    <p class="text-text-muted mb-6 text-sm md:text-base leading-relaxed max-w-3xl">
        Berikut kumpulan dokumen laporan berkala hasil survey kepuasan masyarakat di UPBU Kelas I Kalimarau. Klik dokumen untuk melihat rincian laporan:
    </p>

    @php
        $reports = \App\Models\SurveyReport::published()
            ->orderBy('sort_order')
            ->orderByDesc('period_date')
            ->get();
    @endphp

    @if($reports->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5 mt-4">
            @foreach($reports as $doc)
                <a href="{{ $doc->link_url }}" target="_blank" rel="noopener noreferrer" class="group flex flex-col bg-white rounded-xl overflow-hidden border border-border-soft/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-300">
                    <!-- Compact Thumbnail Section -->
                    <div class="relative w-full aspect-[4/3] bg-surface flex items-center justify-center overflow-hidden border-b border-border-soft/70">
                        <img src="{{ $doc->thumbnail_url }}"
                             alt="Cover Survey {{ $doc->title }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo-header.png') }}'; this.className='w-full h-full object-cover opacity-50';"
                             loading="lazy">

                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/15 transition-colors duration-300"></div>

                        <!-- View Icon overlay -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200 scale-[0.98] group-hover:scale-100">
                            <div class="bg-white/95 backdrop-blur-sm w-10 h-10 rounded-full flex items-center justify-center text-navy-dark shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 flex-1 flex flex-col justify-between bg-white">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-gold-ink bg-gold/10 px-2 py-0.5 rounded">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Laporan
                            </span>
                            <svg class="w-4 h-4 text-text-muted/60 group-hover:text-gold group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>

                        <h4 class="font-bold text-navy-dark group-hover:text-navy text-sm md:text-base leading-snug">
                            {{ $doc->title }}
                        </h4>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="p-8 text-center bg-gray-50 border border-gray-200 rounded-xl text-gray-500">
            <p class="text-sm">Belum ada dokumen survei yang dipublikasikan saat ini.</p>
        </div>
    @endif
</div>

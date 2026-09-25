@php
    $urlAero = asset('documents/tarif/tarif-aeronautika.pdf');
    $urlNonAero = asset('documents/tarif/tarif-non-aeronautika.pdf');
@endphp

<div x-data="{
    activeTab: 'aero',
    docs: {
        aero: {
            title: 'Tarif Pelayanan Jasa Penerbangan (Aeronautika)',
            desc: 'Dokumen resmi rincian tarif aeronautika UPBU Kelas I Kalimarau (PDF)',
            url: '{{ $urlAero }}',
            filename: 'tarif-aeronautika-kalimarau.pdf'
        },
        nonaero: {
            title: 'Tarif Pelayanan Jasa Penunjang (Non Aeronautika)',
            desc: 'Dokumen resmi rincian tarif non-aeronautika UPBU Kelas I Kalimarau (PDF)',
            url: '{{ $urlNonAero }}',
            filename: 'tarif-non-aeronautika-kalimarau.pdf'
        }
    },
    get currentDoc() {
        return this.docs[this.activeTab] || this.docs.aero;
    }
}" class="w-full max-w-5xl mx-auto space-y-6">
    <p class="text-text-muted text-base md:text-lg leading-relaxed max-w-3xl">
        Informasi resmi mengenai rincian tarif pelayanan jasa kebandarudaraan, baik untuk layanan penerbangan (Aeronautika) maupun layanan penunjang non-penerbangan (Non Aeronautika) di UPBU Kelas I Kalimarau.
    </p>

    <!-- Tab Navigation -->
    <div class="flex flex-col sm:flex-row p-1.5 bg-surface/80 backdrop-blur-sm rounded-2xl border border-border-soft">
        <button type="button"
                @click="activeTab = 'aero'"
                :class="activeTab === 'aero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-border-soft/50 border-b-2 border-transparent'"
                class="flex-1 min-h-11 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition duration-200 flex items-center justify-center gap-2.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Tarif Aero
        </button>
        <button type="button"
                @click="activeTab = 'nonaero'"
                :class="activeTab === 'nonaero' ? 'bg-white text-navy-dark shadow-sm font-bold border-b-2 border-gold' : 'text-text-muted hover:text-navy hover:bg-border-soft/50 border-b-2 border-transparent'"
                class="flex-1 min-h-11 py-3 px-6 rounded-xl text-sm md:text-base font-medium transition duration-200 flex items-center justify-center gap-2.5 mt-1 sm:mt-0 sm:ml-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a1 1 0 00-1-1H6a1 1 0 00-1 1v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Tarif Non Aero
        </button>
    </div>

    <!-- Unified Document Viewer Card -->
    <div class="overflow-hidden rounded-2xl border border-border-soft bg-white shadow-sm">
        <!-- Document Toolbar / Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 py-4 sm:px-6 sm:py-5 bg-surface/75 border-b border-border-soft">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-xl bg-navy/10 text-navy flex items-center justify-center shrink-0 mr-4 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-navy-dark leading-tight" x-text="currentDoc.title">
                        Tarif Pelayanan Jasa Penerbangan (Aeronautika)
                    </h2>
                    <p class="text-xs sm:text-sm text-text-muted mt-1" x-text="currentDoc.desc">
                        Dokumen resmi rincian tarif aeronautika UPBU Kelas I Kalimarau (PDF)
                    </p>
                </div>
            </div>
            <div class="flex items-center">
                <a :href="currentDoc.url"
                   :download="currentDoc.filename"
                   href="{{ $urlAero }}"
                   download="tarif-aeronautika-kalimarau.pdf"
                   target="_blank"
                   rel="noopener"
                   class="inline-flex min-h-11 w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-navy px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-navy-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Unduh Dokumen</span>
                </a>
            </div>
        </div>

        <!-- PDF Document Viewport -->
        <template x-if="activeTab === 'aero'">
            <x-pdf-document-viewer :url="$urlAero" />
        </template>

        <template x-if="activeTab === 'nonaero'">
            <x-pdf-document-viewer :url="$urlNonAero" />
        </template>
    </div>
</div>
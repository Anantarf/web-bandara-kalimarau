@php
    $documentUrl = asset('documents/standar-pelayanan-2025.pdf');
@endphp

<div class="w-full max-w-5xl mx-auto">
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
                    <h2 class="text-base sm:text-lg font-bold text-navy-dark leading-tight">Standar Pelayanan Tahun 2025</h2>
                    <p class="text-xs sm:text-sm text-text-muted mt-1">Dokumen resmi BLU UPBU Kelas I Kalimarau (PDF)</p>
                </div>
            </div>
            <div class="flex items-center">
                <a href="{{ $documentUrl }}" target="_blank" rel="noopener" download="standar-pelayanan-kalimarau-2025.pdf" class="inline-flex min-h-11 w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-navy px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-navy-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Unduh Dokumen</span>
                </a>
            </div>
        </div>

        <!-- PDF Document Viewport -->
        <x-pdf-document-viewer :url="$documentUrl" />
    </div>
</div>
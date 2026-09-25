@php
    $documentUrl = asset('documents/standar-pelayanan-2025.pdf');
@endphp

<div class="w-full max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 md:p-5 bg-surface rounded-xl border border-border-soft/70">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg bg-navy/10 flex items-center justify-center text-navy shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-extrabold text-navy-dark leading-tight">Standar Pelayanan Tahun 2025</h2>
                <p class="text-xs sm:text-sm text-text-muted mt-0.5">Dokumen resmi BLU UPBU Kelas I Kalimarau (PDF)</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ $documentUrl }}" target="_blank" rel="noopener" download class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg bg-navy px-4 py-2 text-sm font-bold text-white transition-colors hover:bg-navy-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Unduh Dokumen</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 md:p-5 border border-border-soft/70 shadow-sm relative">
        <x-pdf-document-viewer :url="$documentUrl" />
    </div>
</div>
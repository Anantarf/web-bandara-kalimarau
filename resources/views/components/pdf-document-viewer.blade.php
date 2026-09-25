@props(['url'])

<div data-document-url="{{ $url }}" x-data="pdfDocumentViewer($el.dataset.documentUrl)" x-ref="viewport" class="relative w-full h-[580px] md:h-[700px] overflow-hidden bg-slate-100/70">
    <div x-show="loading" class="absolute inset-0 z-10 flex items-center justify-center bg-white/70 backdrop-blur-xs" aria-live="polite">
        <div class="inline-block animate-spin rounded-full h-9 w-9 border-4 border-navy border-t-transparent"></div>
    </div>
    <p x-show="failed" x-cloak class="px-6 py-12 text-center text-sm font-medium text-text-muted">Dokumen tidak dapat dimuat saat ini. Silakan gunakan tombol unduh di atas untuk melihat berkas.</p>
    <div x-ref="pages" class="flex h-full items-start justify-center overflow-auto p-4 sm:p-6 md:p-8"></div>

    <div x-show="pageCount > 1" x-cloak class="absolute inset-x-0 bottom-4 z-20 flex justify-center pointer-events-none">
        <div class="inline-flex items-center gap-2 rounded-full bg-navy-dark/90 px-3.5 py-1.5 text-white shadow-lg backdrop-blur-md pointer-events-auto border border-white/10">
            <button type="button" @click="previousPage" :disabled="pageNumber <= 1 || loading" class="inline-flex size-8 items-center justify-center rounded-full text-white/80 transition hover:bg-white/15 hover:text-white disabled:opacity-30 disabled:hover:bg-transparent" aria-label="Halaman sebelumnya" title="Halaman sebelumnya">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m15 18-6-6 6-6" /></svg>
            </button>
            <span class="min-w-14 text-center text-xs font-bold text-white tracking-wide" x-text="`${pageNumber} / ${pageCount}`"></span>
            <button type="button" @click="nextPage" :disabled="pageNumber >= pageCount || loading" class="inline-flex size-8 items-center justify-center rounded-full text-white/80 transition hover:bg-white/15 hover:text-white disabled:opacity-30 disabled:hover:bg-transparent" aria-label="Halaman berikutnya" title="Halaman berikutnya">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 18 6-6-6-6" /></svg>
            </button>
        </div>
    </div>
</div>
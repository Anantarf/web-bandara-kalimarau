@props(['url'])

<div data-document-url="{{ $url }}" x-data="pdfDocumentViewer($el.dataset.documentUrl)" x-ref="viewport" class="aspect-[4/3] md:aspect-[8/5] w-full max-w-4xl mx-auto rounded-lg overflow-hidden bg-surface border border-border-soft/70 shadow-inner relative">
    <div x-show="loading" class="absolute inset-0 z-10 flex items-center justify-center bg-surface/80" aria-live="polite">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gold border-t-transparent"></div>
    </div>
    <p x-show="failed" x-cloak class="px-6 py-8 text-center text-sm text-text-muted">Dokumen tidak dapat dimuat saat ini.</p>
    <div x-ref="pages" class="flex h-full items-start justify-center overflow-auto p-3"></div>

    <div x-show="pageCount > 1" x-cloak class="absolute inset-x-0 bottom-0 flex items-center justify-center gap-2 border-t border-border-soft/70 bg-white/95 px-3 py-2 backdrop-blur-sm">
        <button type="button" @click="previousPage" :disabled="pageNumber <= 1 || loading" class="inline-flex size-9 items-center justify-center rounded-lg text-navy transition hover:bg-surface disabled:cursor-not-allowed disabled:opacity-40" aria-label="Halaman sebelumnya" title="Halaman sebelumnya">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" /></svg>
        </button>
        <span class="min-w-12 text-center text-xs font-bold text-navy" x-text="`${pageNumber} / ${pageCount}`"></span>
        <button type="button" @click="nextPage" :disabled="pageNumber >= pageCount || loading" class="inline-flex size-9 items-center justify-center rounded-lg text-navy transition hover:bg-surface disabled:cursor-not-allowed disabled:opacity-40" aria-label="Halaman berikutnya" title="Halaman berikutnya">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6" /></svg>
        </button>
    </div>
</div>
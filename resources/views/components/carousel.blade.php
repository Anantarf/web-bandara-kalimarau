@props(['images' => [], 'awards' => []])

@php
    $items = !empty($awards)
        ? $awards
        : array_map(fn ($img) => [
            'id' => null,
            'title' => 'Penghargaan Bandara Kalimarau',
            'issuer' => 'UPBU Kelas I Kalimarau',
            'year' => null,
            'description' => null,
            'image' => $img,
        ], $images);
@endphp

@if(count($items) > 0)
<div class="w-full" x-data="{
    activeSlide: 0,
    items: {{ Js::from($items) }},
    get currentItem() {
        return this.items[this.activeSlide] || {};
    },
    isModalOpen: false,
    autoplayInterval: null,
    isPaused: false,
    touchStartX: 0,
    touchEndX: 0,
    next(manual = false) {
        this.activeSlide = (this.activeSlide + 1) % this.items.length;
        if (manual) this.restartAutoplay();
    },
    prev(manual = false) {
        this.activeSlide = (this.activeSlide - 1 + this.items.length) % this.items.length;
        if (manual) this.restartAutoplay();
    },
    startAutoplay() {
        this.stopAutoplay();
        this.autoplayInterval = setInterval(() => {
            if (!this.isModalOpen && !this.isPaused) {
                this.next(false);
            }
        }, 7000);
    },
    restartAutoplay() {
        this.stopAutoplay();
        this.startAutoplay();
    },
    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    },
    openModal() {
        this.isModalOpen = true;
        this.stopAutoplay();
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.isModalOpen = false;
        this.startAutoplay();
        document.body.style.overflow = '';
    }
}"
x-init="startAutoplay()"
@mouseenter="isPaused = true"
@mouseleave="isPaused = false"
@focusin="isPaused = true"
@focusout="isPaused = false"
@touchstart.passive="touchStartX = $event.changedTouches[0].screenX"
@touchend.passive="
    touchEndX = $event.changedTouches[0].screenX;
    if (touchEndX < touchStartX - 45) { next(true); }
    else if (touchEndX > touchStartX + 45) { prev(true); }
"
@keydown.arrow-right.window="if (!isModalOpen) next(true)"
@keydown.arrow-left.window="if (!isModalOpen) prev(true)">

    <!-- Main Showcase Canvas -->
    <div class="relative w-full rounded-2xl bg-gradient-to-b from-gray-50/80 to-surface border border-border-soft p-4 sm:p-6 md:p-8 flex flex-col items-center shadow-xs">

        <!-- Certificate Frame (Unblocked, Full Visual Fidelity) -->
        <div class="relative w-full flex items-center justify-center min-h-[260px] sm:min-h-[320px] md:min-h-[380px]">
            <template x-for="(item, index) in items" :key="index">
                <div x-show="activeSlide === index"
                     x-cloak
                     x-transition:enter="transition-opacity ease-in-out duration-700"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in-out duration-500 absolute"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="flex flex-col items-center justify-center cursor-zoom-in group max-w-full"
                     @click="openModal()"
                     :title="'Klik untuk memperbesar ' + (item.title || 'Penghargaan')">

                    <div class="relative bg-white rounded-xl shadow-md border border-gray-200/90 p-2 sm:p-3 transition-transform duration-300 group-hover:scale-[1.015] group-hover:shadow-lg">
                        <img :src="item.image"
                             loading="lazy"
                             class="max-w-full max-h-[240px] sm:max-h-[300px] md:max-h-[360px] w-auto h-auto object-contain rounded-lg select-none"
                             :alt="item.title || 'Penghargaan'">

                        <!-- Subtle Floating Zoom Pill (Top Right, Non-Intrusive) -->
                        <div class="absolute top-4 right-4 bg-navy/85 hover:bg-navy text-white text-xs font-medium px-3 py-1.5 rounded-full shadow-md backdrop-blur-xs flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                            <span>Perbesar</span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Award Details / Metadata Card -->
        <div class="mt-6 text-center max-w-2xl px-2 min-h-[4.5rem] flex flex-col items-center justify-center">
            <template x-if="currentItem.year">
                <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-xs font-bold bg-gold/15 text-gold-ink border border-gold/25 mb-2" x-text="'Tahun ' + currentItem.year"></span>
            </template>

            <h3 class="text-base sm:text-lg md:text-xl font-bold text-navy-dark leading-snug" x-text="currentItem.title"></h3>

            <template x-if="currentItem.issuer">
                <p class="text-xs sm:text-sm text-text-muted font-medium mt-1 flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span x-text="currentItem.issuer"></span>
                </p>
            </template>

            <template x-if="currentItem.description">
                <p class="text-xs text-gray-500 mt-2 line-clamp-2 max-w-lg" x-text="currentItem.description"></p>
            </template>
        </div>

        <!-- Clean Bottom Navigation & Counter Bar -->
        <div class="mt-6 pt-5 border-t border-border-soft/80 w-full flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Prev Button -->
            <button type="button"
                    @click="prev(true)"
                    class="order-2 sm:order-1 inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl border border-gray-200 bg-white text-navy-dark hover:text-navy hover:bg-gray-50 hover:border-navy/30 transition-all font-semibold text-xs sm:text-sm shadow-xs focus:ring-2 focus:ring-navy/20 focus:outline-hidden"
                    aria-label="Penghargaan sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Sebelumnya</span>
            </button>

            <!-- Counter & Elegant Progress Track -->
            <div class="order-1 sm:order-2 flex flex-col items-center gap-2">
                <div class="flex items-center gap-2 text-xs font-semibold text-navy-dark">
                    <span class="font-mono text-sm font-extrabold text-navy" x-text="String(activeSlide + 1).padStart(2, '0')"></span>
                    <span class="text-gray-300">/</span>
                    <span class="font-mono text-gray-500" x-text="String(items.length).padStart(2, '0')"></span>
                    <span class="text-gray-400 text-[11px] font-normal hidden md:inline ml-1">Penghargaan</span>
                </div>

                <div class="w-32 sm:w-44 h-1.5 bg-gray-200/80 rounded-full overflow-hidden" role="progressbar" :aria-valuenow="activeSlide + 1" :aria-valuemin="1" :aria-valuemax="items.length">
                    <div class="h-full bg-gold transition-all duration-700 ease-out rounded-full"
                         :style="'width: ' + (((activeSlide + 1) / items.length) * 100) + '%'"></div>
                </div>
            </div>

            <!-- Next Button -->
            <button type="button"
                    @click="next(true)"
                    class="order-3 inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl border border-gray-200 bg-white text-navy-dark hover:text-navy hover:bg-gray-50 hover:border-navy/30 transition-all font-semibold text-xs sm:text-sm shadow-xs focus:ring-2 focus:ring-navy/20 focus:outline-hidden"
                    aria-label="Penghargaan berikutnya">
                <span>Selanjutnya</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Fullscreen Modal / Lightbox -->
    <template x-teleport="body">
        <div x-cloak
             x-show="isModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 backdrop-blur-none"
             x-transition:enter-end="opacity-100 backdrop-blur-sm"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 backdrop-blur-sm"
             x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="fixed inset-0 z-[70] flex flex-col items-center justify-between bg-black/90 p-4 sm:p-6"
             role="dialog"
             aria-modal="true"
             aria-label="Pratinjau penghargaan"
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()"
             @keydown.arrow-right.window="if(isModalOpen) next()"
             @keydown.arrow-left.window="if(isModalOpen) prev()">

            <!-- Modal Header (Close button & counter) -->
            <div class="w-full flex items-center justify-between max-w-5xl z-50">
                <span class="text-white/80 text-xs sm:text-sm font-mono font-medium">
                    <span class="text-gold font-bold" x-text="String(activeSlide + 1).padStart(2, '0')"></span> / <span x-text="String(items.length).padStart(2, '0')"></span>
                </span>
                <button @click="closeModal()" class="inline-flex h-11 w-11 items-center justify-center text-navy hover:text-gold bg-white/95 hover:bg-white rounded-full transition-colors shadow-lg" aria-label="Tutup pratinjau">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Center Content -->
            <div class="relative max-w-5xl w-full flex items-center justify-center my-auto p-2">
                <button @click.stop="prev()" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm flex items-center justify-center transition-colors z-50" aria-label="Penghargaan sebelumnya">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <img :src="currentItem.image"
                     loading="lazy"
                     class="w-auto h-auto max-h-[75vh] object-contain select-none rounded-xl shadow-2xl ring-1 ring-white/20"
                     :alt="currentItem.title || 'Penghargaan Zoom'">

                <button @click.stop="next()" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm flex items-center justify-center transition-colors z-50" aria-label="Penghargaan berikutnya">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Modal Footer Caption -->
            <div class="text-center max-w-2xl px-4 py-2 text-white z-50">
                <h4 class="text-sm sm:text-base font-bold text-white leading-snug" x-text="currentItem.title"></h4>
                <p class="text-xs text-white/70 mt-0.5" x-show="currentItem.issuer" x-text="currentItem.issuer"></p>
            </div>
        </div>
    </template>
</div>
@endif

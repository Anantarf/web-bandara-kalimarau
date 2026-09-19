@props(['images' => []])

@if(count($images) > 0)
<div class="w-full" x-data="{
    activeSlide: 0,
    slides: {{ json_encode($images) }},
    isModalOpen: false,
    autoplayInterval: null,
    next() {
        this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1;
    },
    prev() {
        this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1;
    },
    startAutoplay() {
        this.autoplayInterval = setInterval(() => { this.next() }, 4000);
    },
    stopAutoplay() {
        clearInterval(this.autoplayInterval);
    },
    openModal() {
        this.isModalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.isModalOpen = false;
        document.body.style.overflow = '';
    }
}" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
    <!-- Carousel Track -->
    <div class="relative w-full overflow-hidden bg-navy-dark/[0.06] rounded-2xl border border-navy-dark/5 shadow-inner h-64 sm:h-72 md:h-80 flex items-center justify-center group/track">

        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" x-cloak
                 x-transition:enter="transition ease-in-out duration-400"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in-out duration-400 absolute inset-0"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="w-full h-full flex items-center justify-center p-5 sm:p-8 cursor-zoom-in relative z-10"
                 @click="openModal()">

                <!-- White mat card so the certificate reads as mounted, not floating -->
                <div class="bg-white rounded-lg shadow-xl p-2.5 sm:p-3 max-w-full max-h-full transition-transform duration-500 group-hover/track:scale-[1.03]">
                    <img :src="slide" loading="lazy" class="max-w-full max-h-[13rem] sm:max-h-[15rem] md:max-h-[17rem] object-contain rounded" alt="Penghargaan">
                </div>

                <!-- Hover Hint (Magnifying Glass) -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/track:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <div class="bg-navy/90 text-white p-3.5 rounded-full shadow-xl backdrop-blur-md transform scale-[0.98] group-hover/track:scale-100 transition duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
            </div>
        </template>

        <!-- Previous Button -->
        <button @click="prev" class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 h-11 w-11 md:h-12 md:w-12 rounded-full border border-border-soft bg-white text-navy flex items-center justify-center transition-colors duration-200 z-20 group" aria-label="Penghargaan sebelumnya">
            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Next Button -->
        <button @click="next" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 h-11 w-11 md:h-12 md:w-12 rounded-full border border-border-soft bg-white text-navy flex items-center justify-center transition-colors duration-200 z-20 group" aria-label="Penghargaan berikutnya">
            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20 bg-white px-1 py-1 rounded-full border border-border-soft" role="tablist">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index"

                        class="carousel-indicator -mx-2.5 h-11 w-11 rounded-full" :aria-label="'Tampilkan penghargaan ke-' + (index + 1)" role="tab" :aria-selected="activeSlide === index"></button>
            </template>
        </div>
    </div>

    <!-- Fullscreen Modal -->
    <template x-teleport="body">
        <div x-cloak
             x-show="isModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 backdrop-blur-none"
             x-transition:enter-end="opacity-100 backdrop-blur-sm"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 backdrop-blur-sm"
             x-transition:leave-end="opacity-0 backdrop-blur-none"

             class="fixed inset-0 z-[70] flex items-center justify-center bg-black/90 p-4 sm:p-10" role="dialog" aria-modal="true" aria-label="Pratinjau penghargaan"
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()"
             @keydown.arrow-right.window="if(isModalOpen) next()"
             @keydown.arrow-left.window="if(isModalOpen) prev()">

            <button @click="closeModal()" class="absolute top-4 right-4 sm:top-6 sm:right-6 inline-flex h-11 w-11 items-center justify-center text-navy hover:text-gold bg-white/90 hover:bg-white rounded-full transition-colors z-50" aria-label="Tutup pratinjau">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <button @click.stop="prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Penghargaan sebelumnya">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div class="relative max-w-5xl w-full flex items-center justify-center p-4">
                <img :src="slides[activeSlide]" loading="lazy" class="w-auto h-auto max-h-[85vh] object-contain select-none rounded-xl shadow-xl ring-1 ring-white/20" alt="Penghargaan Zoom">
            </div>

            <button @click.stop="next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Penghargaan berikutnya">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </template>
</div>
@endif

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
    <div class="relative w-full overflow-hidden bg-white rounded-2xl shadow-[inset_0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 h-56 sm:h-64 md:h-72 flex items-center justify-center">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300 absolute inset-0"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="w-full h-full flex items-center justify-center p-6 cursor-zoom-in relative z-10"
                 @click="openModal()">
                <img :src="slide" class="max-w-full max-h-full object-contain drop-shadow-xl rounded-lg border border-gray-100/50" alt="Penghargaan">
            </div>
        </template>

        <!-- Previous Button -->
        <button @click="prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 hover:bg-white text-navy flex items-center justify-center shadow-md backdrop-blur transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:-translate-x-1 z-20 group" aria-label="Previous">
            <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Next Button -->
        <button @click="next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/90 hover:bg-white text-navy flex items-center justify-center shadow-md backdrop-blur transition-all duration-300 transform hover:scale-110 hover:shadow-lg hover:translate-x-1 z-20 group" aria-label="Next">
            <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
        
        <!-- Indicators -->
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-2.5 z-20 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="activeSlide === index ? 'bg-navy w-8' : 'bg-gray-300 hover:bg-gray-400 w-2'" 
                        class="h-2 rounded-full transition-all duration-500 ease-out" aria-label="Go to slide"></button>
            </template>
        </div>
    </div>
    
    <div class="flex items-center justify-center mt-4 text-gray-400">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
        <p class="text-sm font-medium">Klik gambar untuk memperbesar</p>
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
             style="display: none; z-index: 9999;"
             class="fixed inset-0 flex items-center justify-center bg-black/90 p-4 sm:p-10"
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()"
             @keydown.arrow-right.window="if(isModalOpen) next()"
             @keydown.arrow-left.window="if(isModalOpen) prev()">
             
            <button @click="closeModal()" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-white hover:text-gray-300 bg-black/50 rounded-full p-2 z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        
        <button @click.stop="prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Previous">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <div class="relative max-w-5xl w-full flex items-center justify-center p-4">
            <img :src="slides[activeSlide]" class="w-auto h-auto max-h-[85vh] object-contain select-none rounded-xl shadow-2xl ring-1 ring-white/20" alt="Penghargaan Zoom">
        </div>

        <button @click.stop="next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Next">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    </template>
</div>
@endif

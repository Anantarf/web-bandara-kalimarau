@props(['images' => []])

@if(count($images) > 0)
<div class="mt-12" x-data="{ 
    activeSlide: 0, 
    slides: {{ json_encode($images) }},
    isModalOpen: false,
    next() {
        this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1;
    },
    prev() {
        this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1;
    }
}">
    <!-- Carousel Track -->
    <div class="relative w-full overflow-hidden bg-gray-100 rounded-2xl shadow-inner h-64 sm:h-80 md:h-96 flex items-center justify-center">
        
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300 absolute inset-0"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="w-full h-full flex items-center justify-center p-4 cursor-pointer"
                 @click="isModalOpen = true">
                <img :src="slide" class="max-w-full max-h-full object-contain drop-shadow-md rounded" alt="Penghargaan">
            </div>
        </template>

        <!-- Previous Button -->
        <button @click="prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-gray-800 flex items-center justify-center shadow backdrop-blur transition z-10" aria-label="Previous">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Next Button -->
        <button @click="next" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-gray-800 flex items-center justify-center shadow backdrop-blur transition z-10" aria-label="Next">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
        
        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        :class="activeSlide === index ? 'bg-blue-600 w-6' : 'bg-gray-400 w-2'" 
                        class="h-2 rounded-full transition-all duration-300" aria-label="Go to slide"></button>
            </template>
        </div>
    </div>
    
    <p class="text-center text-sm text-gray-500 mt-3">Klik gambar untuk memperbesar</p>

    <!-- Fullscreen Modal -->
    <div x-show="isModalOpen" 
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 sm:p-10"
         @keydown.escape.window="isModalOpen = false"
         @keydown.arrow-right.window="if(isModalOpen) next()"
         @keydown.arrow-left.window="if(isModalOpen) prev()">
         
        <button @click="isModalOpen = false" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-white hover:text-gray-300 bg-black/50 rounded-full p-2 z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <button @click="prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Previous">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <img :src="slides[activeSlide]" @click.away="isModalOpen = false" class="max-w-full max-h-[90vh] object-contain select-none" alt="Penghargaan Zoom">

        <button @click="next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition z-50" aria-label="Next">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>
@endif

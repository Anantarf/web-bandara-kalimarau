@php
$categories = \App\Models\Facility::query()
    ->orderBy('order')
    ->get()
    ->groupBy('category')
    ->map(fn ($items, $title) => [
        'title' => $title,
        'items' => $items->map(fn ($facility) => [
            'name' => $facility->name,
            'image' => $facility->image_url,
            'details' => $facility->details ?? [],
        ])->values(),
    ])
    ->values();
@endphp

<div x-data="{
        modalOpen: false,
        activeFacility: null,
        openModal(item) {
            this.activeFacility = item;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.modalOpen = false;
            setTimeout(() => { this.activeFacility = null; }, 300);
            document.body.style.overflow = '';
        }
    }" 
    class="pb-12 bg-transparent"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 x-show="loaded" 
                x-transition:enter="transition-all ease-out duration-1000 delay-[800ms]" 
                x-transition:enter-start="opacity-0 translate-y-8" 
                x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;"
                class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6">Fasilitas Lengkap</h1>
            
            <div x-show="loaded" 
                 x-transition:enter="transition-all ease-out duration-1000 delay-[1000ms]" 
                 x-transition:enter-start="opacity-0 scale-0" 
                 x-transition:enter-end="opacity-100 scale-100"
                 style="display: none;"
                 class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
            
            <p x-show="loaded" 
               x-transition:enter="transition-all ease-out duration-1000 delay-[1200ms]" 
               x-transition:enter-start="opacity-0 translate-y-4" 
               x-transition:enter-end="opacity-100 translate-y-0"
               style="display: none;"
               class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">Kami menyediakan berbagai fasilitas berstandar tinggi untuk memastikan kenyamanan, keamanan, dan kelancaran perjalanan seluruh pengguna jasa bandara.</p>
        </div>

        <div class="space-y-20"
             x-show="loaded"
             x-transition:enter="transition-all ease-out duration-1000 delay-[1400ms]"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             style="display: none;">
            @foreach($categories as $index => $category)
                <div class="facility-category scroll-mt-24">
                    <div class="flex items-center mb-8">
                        <div class="w-10 h-10 rounded-xl bg-navy/10 text-navy flex items-center justify-center mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-navy-dark">{{ $category['title'] }}</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($category['items'] as $item)
                            <button @click="openModal({{ json_encode($item) }})" 
                                    class="group relative bg-white rounded-2xl overflow-hidden shadow border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-gold text-left h-full flex flex-col">
                                
                                <div class="relative h-40 sm:h-48 w-full overflow-hidden bg-gray-100">
                                    <img src="{{ $item['image'] }}" loading="lazy" alt="{{ $item['name'] }}" onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=Fasilitas'" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="p-4 flex-grow flex items-center justify-center border-t border-gray-50">
                                    <h4 class="font-bold text-gray-800 text-center text-sm sm:text-base leading-snug group-hover:text-blue-700 transition-colors">{{ $item['name'] }}</h4>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Detail Fasilitas -->
    <template x-teleport="body">
        <div x-cloak
             x-show="modalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none; z-index: 9999;"
             class="fixed inset-0 flex items-center justify-center bg-black/80 p-4 sm:p-6 lg:p-12"
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()">
             
            <button @click="closeModal()" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-gray-300 hover:text-white bg-black/40 hover:bg-black/60 rounded-full p-2.5 transition-all z-50">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="relative w-full max-w-4xl bg-white rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row transform transition-all"
                 x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop>
                
                <!-- Modal Image Section -->
                <div class="w-full md:w-3/5 lg:w-2/3 h-64 md:h-auto bg-gray-100 relative">
                    <template x-if="activeFacility">
                        <img :src="activeFacility.image" :alt="activeFacility.name" x-on:error="$el.src = 'https://placehold.co/400x300?text=Fasilitas'" class="w-full h-full object-cover">
                    </template>
                </div>

                <!-- Modal Content Section -->
                <div class="w-full md:w-2/5 lg:w-1/3 p-6 sm:p-8 md:p-10 flex flex-col justify-center">
                    <template x-if="activeFacility">
                        <div>
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gold/10 text-gold-dark mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            
                            <h4 class="text-2xl md:text-3xl font-extrabold text-navy-dark mb-6" x-text="activeFacility.name"></h4>
                            
                            <div class="space-y-4">
                                <template x-for="(detail, i) in activeFacility.details" :key="i">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-gray-600 leading-relaxed text-sm md:text-base" x-text="detail"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </template>
</div>

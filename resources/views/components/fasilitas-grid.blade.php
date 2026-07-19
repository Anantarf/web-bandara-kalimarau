@php
$categories = [
    [
        'title' => 'Fasilitas Sisi Udara',
        'items' => [
            [
                'name' => 'Runway',
                'image' => 'https://aptpairport.id/uploads/fasilitas/C71sTmDprY3asQDEhE67W1mojj9Ce1zpTIHiH7E0.jpg',
                'details' => ['Ukuran: 2.250 m x 45 m', 'Daya Dukung: PCN 50 F/C/X/T']
            ],
            [
                'name' => 'Apron',
                'image' => 'https://aptpairport.id/uploads/fasilitas/dcZrrhulEXz09yKVZiYM3WAT6bd39ZNwsqH9aazb.jpg',
                'details' => ['Ukuran: 300 m x 123 m', '8 Parking Stand', 'Daya Dukung: PCN 63 F/C/X/T']
            ],
            [
                'name' => 'Garbarata',
                'image' => 'https://aptpairport.id/uploads/fasilitas/bgAHN6w5yuLszgSDmmlZStirQOoO39y3MXx2rbKU.png',
                'details' => ['Tersedia: 2 Unit', 'Memudahkan akses ke pesawat.']
            ],
            [
                'name' => 'Runway Light',
                'image' => 'https://aptpairport.id/uploads/fasilitas/yqttMTNnma9cbGsTQoMojZZV6LpQ2zmfJEx16e1e.jpg',
                'details' => ['Runway Light', 'Taxiway Light', 'Apron Light', 'P.A.P.I', 'Flood Light']
            ],
            [
                'name' => 'Taxiway',
                'image' => 'https://aptpairport.id/uploads/fasilitas/ZGuuUG3Gm5PbLLDQ2ia9wQiYLq1nnK1JPBaqbrOK.png',
                'details' => ['Taxiway Alpha 173,5 m x 23 m', 'Taxiway Bravo 148 m x 18 m', 'Paralel Taxi 527 m x 18 m']
            ]
        ]
    ],
    [
        'title' => 'Fasilitas Sisi Darat',
        'items' => [
            [
                'name' => 'Terminal Penumpang',
                'image' => 'https://aptpairport.id/uploads/fasilitas/YdG7J8PUBJNjVwrDknCy9f4ejT9v9uolu4JS109d.png',
                'details' => ['Luas: 12.700 m²', 'Kapasitas: 1.5 Juta Penumpang/Tahun']
            ],
            [
                'name' => 'Terminal Kargo',
                'image' => 'https://aptpairport.id/uploads/fasilitas/beCshuIrWRXELJWPyDmVUzUTHv9MvVLSSteW4p2U.png',
                'details' => ['Luas Lini I: 1.148 m²', 'Luas Lini II: 1.623,9 m²', 'Mendukung logistik & pengiriman barang.']
            ],
            [
                'name' => 'Gedung VVIP',
                'image' => 'https://aptpairport.id/uploads/fasilitas/yuchwOrO8mXX58FgWTrti7zJsbmlBJfLfluMR06e.png',
                'details' => ['Luas: 743,60 m²', 'Kenyamanan eksklusif untuk tamu penting.']
            ],
            [
                'name' => 'Parkir & Landscape',
                'image' => 'https://aptpairport.id/uploads/fasilitas/wJg0zN8aFIWkheMTxOmbE4Rx3sHWApOu00rTwguF.png',
                'details' => ['Luas: 30.000 m²', 'Kapasitas luas untuk kendaraan.']
            ]
        ]
    ],
    [
        'title' => 'Fasilitas Umum',
        'items' => [
            [
                'name' => 'Check-in Counter',
                'image' => 'https://aptpairport.id/uploads/fasilitas/1vqnSgDWAaul2e9ygX9CUAT3CdXQnGScKZeTRXgE.png',
                'details' => ['Tersedia: 16 Counter', 'Proses check-in yang cepat dan efisien.']
            ],
            [
                'name' => 'Self Check-In',
                'image' => 'https://aptpairport.id/uploads/fasilitas/ggp83Fvs6KuPVoP49g71gi60FiPE279AUNWm7xuL.png',
                'details' => ['Tersedia mesin self-check-in mandiri untuk memudahkan penumpang tanpa bagasi.']
            ],
            [
                'name' => 'Mushola',
                'image' => 'https://aptpairport.id/uploads/fasilitas/MOtEEUemCyt8eqBC6ljL8klO4PK1nUkMKL7gXmWz.jpg',
                'details' => ['Ruang ibadah yang bersih dan nyaman.']
            ],
            [
                'name' => 'Nursery Room',
                'image' => 'https://aptpairport.id/uploads/fasilitas/QSct13Ok2MtX7qVrAymD2P5RGBr85emkn5qQMUr4.png',
                'details' => ['Fasilitas nursery room untuk ibu dan anak.']
            ]
        ]
    ]
];
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
    class="py-12 bg-gray-50"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-extrabold text-navy-dark mb-4">Fasilitas Lengkap</h2>
            <div class="h-1.5 w-24 bg-gold mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">Kami menyediakan berbagai fasilitas berstandar tinggi untuk memastikan kenyamanan, keamanan, dan kelancaran perjalanan seluruh pengguna jasa bandara.</p>
        </div>

        <div class="space-y-20">
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
                                    <img src="{{ $item['image'] }}" loading="lazy" alt="{{ $item['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                        <img :src="activeFacility.image" :alt="activeFacility.name" class="w-full h-full object-cover">
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

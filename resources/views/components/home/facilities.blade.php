@props(['facilities'])

<!-- Section 5: Fasilitas Bandara -->
    <section id="fasilitas" class="py-16 lg:py-24 bg-surface">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out delay-100">
            <div class="flex flex-col sm:flex-row items-end justify-between mb-8 gap-4">
                <div>
                    <h2 class="font-sans text-3xl md:text-4xl font-extrabold tracking-tight text-navy">Fasilitas Bandara</h2>
                    <p class="text-text-muted text-base mt-2">Kenyamanan dan pelayanan terbaik selama Anda berada di bandara.</p>
                </div>
            </div>

            <!-- Fasilitas -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($facilities as $item)
                    <div class="group bg-white rounded-xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] hover:-translate-y-0.5 transition-all duration-500">
                        <a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="block w-full h-full">
                            <div class="relative overflow-hidden bg-navy-dark aspect-[4/3]">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-text-main text-lg mb-1.5 group-hover:text-gold transition-colors">{{ $item['title'] }}</h3>
                                <p class="text-text-muted text-sm leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-12">
                <a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                    Lihat Semua Fasilitas
                    <x-icon-arrow class="w-4 h-4" />
                </a>
            </div>
        </div>
    </section>

@props(['latestPosts'])

<!-- Section: Berita Terkini -->
    <section class="py-16 lg:py-24 bg-navy-dark">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out delay-100">
            <div class="text-center mb-12">
                <h2 class="font-sans text-3xl md:text-4xl font-extrabold tracking-tight text-white mb-2">Kabar Terbaru dari Gerbang Udara Anda</h2>
                <p class="text-white/70 text-base mt-2 max-w-2xl mx-auto">Ikuti terus informasi, acara, dan pengembangan terbaru langsung dari Bandar Udara Kalimarau.</p>
            </div>

            @if($latestPosts->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestPosts->take(3) as $post)
                        <div class="bg-black/20 backdrop-blur-sm rounded-xl overflow-hidden flex flex-col hover:-translate-y-0.5 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 border border-white/10">
                            <div class="relative overflow-hidden bg-navy-dark aspect-[16/10] shrink-0">
                                @if($post->featured_image_url)
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-navy-dark text-white/20">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="text-white/50 text-sm mb-3">{{ $post->published_at->translatedFormat('d M Y') }}</div>
                                <h3 class="font-sans font-extrabold text-white text-lg leading-snug mb-3 line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-gold transition-colors focus-visible:outline-none focus-visible:underline before:absolute before:inset-0">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-white/60 text-sm leading-relaxed line-clamp-2 mb-6 flex-1">{{ $post->excerpt }}</p>
                                <div class="text-gold font-semibold text-sm flex items-center gap-1 group w-fit mt-auto relative z-10">
                                    Baca Selengkapnya
                                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        Lihat Semua Berita
                    </a>
                </div>
            @else
                <div class="bg-navy rounded-xl p-12 text-center border border-white/5">
                    <svg class="w-16 h-16 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <h3 class="text-xl font-semibold text-white mb-2">Belum Ada Berita</h3>
                    <p class="text-white/50">Berita dan pengumuman akan tampil di sini setelah dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>

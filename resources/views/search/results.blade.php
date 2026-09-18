<x-layouts.public
    title="Pencarian - Bandara Kalimarau"
    description="Cari informasi, berita, dan halaman layanan Bandara Kalimarau."
    :canonical="route('search')"
    robots="noindex, follow"
>
    <!-- Breadcrumb -->
    <div class="bg-surface py-4 sm:py-6 border-b border-border-soft">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Pencarian Informasi'],
            ]" />
        </div>
    </div>

    <!-- Search Header (Golden Standard Compliant) -->
    <div class="py-12 md:py-16 bg-white border-b border-border-soft/70" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h1 x-show="loaded"
                x-cloak
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="font-sans text-2xl md:text-3xl font-extrabold text-navy-dark leading-snug mb-3">Pencarian Informasi</h1>

            <div x-show="loaded"
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 scale-0"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>

            <form action="{{ route('search') }}" method="GET" class="relative group mt-6"
                  x-show="loaded"
                  x-cloak
                  x-transition:enter="transition ease-out duration-500 delay-300"
                  x-transition:enter-start="opacity-0 translate-y-4"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  >
                <div class="absolute inset-y-0 left-0 flex items-center pl-6 pointer-events-none text-text-muted/70 group-focus-within:text-navy transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" value="{{ $keyword }}" placeholder="Ketik kata kunci yang ingin Anda cari..."
                       class="w-full bg-surface text-navy font-medium text-lg rounded-2xl sm:rounded-full py-4 sm:py-5 pl-16 pr-32 sm:pr-40 shadow-sm border border-border-soft focus:bg-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-gold transition placeholder:text-text-muted"
                       required autocomplete="off">
                <button type="submit" class="absolute inset-y-2 right-2 bg-navy hover:bg-navy-dark text-white px-6 sm:px-8 py-2 rounded-xl sm:rounded-full font-bold text-sm sm:text-base transition shadow-sm hover:shadow-md">
                    Cari
                </button>
            </form>
            @if(!empty($keyword))
                <p class="mt-6 text-text-muted text-sm sm:text-base">Menampilkan hasil pencarian untuk: <strong class="text-navy-dark">"{{ $keyword }}"</strong></p>
            @endif
        </div>
    </div>

    <!-- Results Area -->
    <div class="py-12 bg-white min-h-[50vh]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-4xl mx-auto px-4"
             x-show="loaded" x-cloak x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
             >

            @if(empty($keyword))
                <!-- Initial Empty State -->
                <div class="bg-white rounded-2xl p-12 text-center border border-border-soft shadow-sm max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mx-auto mb-6 text-text-muted">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xl font-bold text-navy mb-2">Mulai Pencarian</h2>
                    <p class="text-text-muted">Ketikkan kata kunci pada kolom di atas untuk mencari jadwal penerbangan, berita terbaru, atau informasi layanan publik.</p>
                </div>
            @else

                @if($posts->isEmpty() && $pages->isEmpty() && $documents->isEmpty())
                    <!-- Not Found State -->
                    <div class="bg-white rounded-2xl p-12 text-center border border-border-soft shadow-sm max-w-2xl mx-auto">
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h2 class="text-xl font-bold text-navy mb-2">Informasi Tidak Ditemukan</h2>
                        <p class="text-text-muted">Maaf, kami tidak dapat menemukan hasil yang cocok dengan kata kunci <strong class="text-navy">"{{ $keyword }}"</strong>. Silakan coba menggunakan kata kunci lain yang lebih umum.</p>
                    </div>
                @else

                    <div class="space-y-12">
                        @if($pages->isNotEmpty())
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <h2 class="text-2xl font-bold text-navy">Halaman Informasi</h2>
                                    <span class="bg-navy/10 text-navy font-semibold px-2.5 py-0.5 rounded-full text-sm">{{ $pages->count() }}</span>
                                </div>
                                <div class="grid gap-4">
                                    @foreach($pages as $page)
                                    <a href="{{ route('pages.show', $page->slug) }}" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-gold/50 hover:-translate-y-0.5 transition duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-gold-ink transition-colors mb-2">{{ $page->title }}</h3>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $page->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 180) }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-navy group-hover:text-gold transition-colors">
                                                <svg class="w-4 h-4 -rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($posts->isNotEmpty())
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <h2 class="text-2xl font-bold text-navy">Berita & Pengumuman</h2>
                                    <span class="bg-navy/10 text-navy font-semibold px-2.5 py-0.5 rounded-full text-sm">{{ $posts->count() }}</span>
                                </div>
                                <div class="grid gap-4">
                                    @foreach($posts as $post)
                                    <a href="{{ route('posts.show', $post->slug) }}" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-gold/50 hover:-translate-y-0.5 transition duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-gold-ink transition-colors mb-1.5">{{ $post->title }}</h3>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <span class="text-xs font-semibold text-gold tracking-wide uppercase">Berita</span>
                                                    <span class="w-1 h-1 rounded-full bg-border-soft"></span>
                                                    <span class="text-xs text-text-muted">{{ $post->published_at->translatedFormat('d M Y') }}</span>
                                                </div>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 180) }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-navy group-hover:text-gold transition-colors">
                                                <svg class="w-4 h-4 -rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($documents->isNotEmpty())
                            <div>
                                <div class="flex items-center gap-3 mb-6">
                                    <h2 class="text-2xl font-bold text-navy">Dokumen PPID</h2>
                                    <span class="bg-navy/10 text-navy font-semibold px-2.5 py-0.5 rounded-full text-sm">{{ $documents->count() }}</span>
                                </div>
                                <div class="grid gap-4">
                                    @foreach($documents as $doc)
                                    <a href="{{ $doc->file_url }}" target="_blank" rel="noopener" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-gold/50 hover:-translate-y-0.5 transition duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-gold-ink transition-colors mb-1.5">{{ $doc->title }}</h3>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <span class="text-xs font-semibold text-gold tracking-wide uppercase">Dokumen</span>
                                                    <span class="w-1 h-1 rounded-full bg-border-soft"></span>
                                                    <span class="text-xs text-text-muted">{{ $doc->published_at ? $doc->published_at->translatedFormat('d M Y') : '' }}</span>
                                                </div>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $doc->description }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-navy group-hover:text-gold transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts.public>

<x-layouts.public
    title="Pencarian - Bandara Kalimarau"
    description="Cari informasi, berita, dan halaman layanan Bandara Kalimarau."
    :canonical="route('search')"
    :withHeaderPadding="true"
    robots="noindex, follow"
>
    <!-- Search Header -->
    <div class="relative bg-navy-dark pt-20 pb-16 lg:pt-28 lg:pb-24 overflow-hidden border-b border-white/10">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-[url('{{ asset('images/pattern-bg.png') }}')] opacity-5"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-sky/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-72 h-72 bg-gold/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-3xl mx-auto px-4 text-center">
            <h1 class="font-sans text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-8">Pencarian Informasi</h1>
            
            <form action="{{ route('search') }}" method="GET" class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-6 pointer-events-none text-navy/40 group-focus-within:text-sky transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" value="{{ $keyword }}" placeholder="Ketik kata kunci yang ingin Anda cari..." 
                       class="w-full bg-white text-navy font-medium text-lg rounded-2xl sm:rounded-full py-4 sm:py-5 pl-16 pr-32 sm:pr-40 shadow-xl shadow-navy-dark/20 focus:outline-none focus:ring-4 focus:ring-sky/30 border-2 border-transparent focus:border-sky transition-all placeholder-navy/30" 
                       required autocomplete="off">
                <button type="submit" class="absolute inset-y-2 right-2 bg-navy hover:bg-navy-dark text-white px-6 sm:px-8 py-2 rounded-xl sm:rounded-full font-bold text-sm sm:text-base transition-all hover:shadow-md hover:-translate-y-0.5">
                    Cari
                </button>
            </form>
            @if(!empty($keyword))
                <p class="mt-6 text-white/70 text-sm sm:text-base">Menampilkan hasil pencarian untuk: <strong class="text-white">"{{ $keyword }}"</strong></p>
            @endif
        </div>
    </div>

    <!-- Results Area -->
    <div class="py-16 lg:py-24 bg-surface min-h-[50vh]" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-4xl mx-auto px-4"
             x-show="loaded" x-transition:enter="transition-all ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
             style="display: none;">
            
            @if(empty($keyword))
                <!-- Initial Empty State -->
                <div class="bg-white rounded-3xl p-12 text-center border border-border-soft shadow-sm max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mx-auto mb-6 text-text-muted">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h2 class="text-xl font-bold text-navy mb-2">Mulai Pencarian</h2>
                    <p class="text-text-muted">Ketikkan kata kunci pada kolom di atas untuk mencari jadwal penerbangan, berita terbaru, atau informasi layanan publik.</p>
                </div>
            @else
                
                @if($posts->isEmpty() && $pages->isEmpty() && $documents->isEmpty())
                    <!-- Not Found State -->
                    <div class="bg-white rounded-3xl p-12 text-center border border-border-soft shadow-sm max-w-2xl mx-auto">
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
                                    <a href="{{ route('pages.show', $page->slug) }}" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-sky/50 hover:-translate-y-1 transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-sky transition-colors mb-2">{{ $page->title }}</h3>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $page->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 180) }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-sky group-hover:text-white transition-colors">
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
                                    <a href="{{ route('posts.show', $post->slug) }}" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-sky/50 hover:-translate-y-1 transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-sky transition-colors mb-1.5">{{ $post->title }}</h3>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <span class="text-xs font-semibold text-gold tracking-wide uppercase">Berita</span>
                                                    <span class="w-1 h-1 rounded-full bg-border-soft"></span>
                                                    <span class="text-xs text-text-muted">{{ $post->published_at->translatedFormat('d M Y') }}</span>
                                                </div>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 180) }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-sky group-hover:text-white transition-colors">
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
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($doc->file_path) }}" target="_blank" class="group block bg-white rounded-2xl p-6 border border-border-soft shadow-sm hover:shadow-lg hover:border-sky/50 hover:-translate-y-1 transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-navy group-hover:text-sky transition-colors mb-1.5">{{ $doc->title }}</h3>
                                                <div class="flex items-center gap-2 mb-3">
                                                    <span class="text-xs font-semibold text-gold tracking-wide uppercase">Dokumen</span>
                                                    <span class="w-1 h-1 rounded-full bg-border-soft"></span>
                                                    <span class="text-xs text-text-muted">{{ $doc->published_at ? $doc->published_at->translatedFormat('d M Y') : '' }}</span>
                                                </div>
                                                <p class="text-text-muted text-sm leading-relaxed line-clamp-2">{{ $doc->description }}</p>
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-surface shrink-0 flex items-center justify-center text-navy group-hover:bg-sky group-hover:text-white transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
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

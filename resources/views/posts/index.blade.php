<x-layouts.public
    title="Berita - Bandara Kalimarau"
    description="Informasi dan pengumuman terbaru dari Bandara Kalimarau."
    :canonical="route('posts.index')"
>
    <div class="bg-gray-50 py-8 border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-medium" aria-current="page">Berita</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="font-sans text-3xl md:text-4xl font-bold text-navy mb-2">Berita Terkini</h1>
                    <p class="text-gray-600">Informasi dan pengumuman terbaru dari Bandara Kalimarau.</p>
                </div>
                
                <!-- Search & Filter Form -->
                <form action="{{ route('posts.index') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full sm:w-48">
                        <select name="category" class="w-full pl-4 pr-10 py-2.5 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 appearance-none text-sm" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <option value="pengumuman" {{ request('category') === 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="berita" {{ request('category') === 'berita' ? 'selected' : '' }}>Berita</option>
                            <option value="artikel" {{ request('category') === 'artikel' ? 'selected' : '' }}>Artikel</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    
                    <div class="flex w-full sm:w-auto">
                        <div class="relative w-full sm:w-64">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full pl-4 pr-10 py-2.5 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @if(request('search'))
                                <a href="{{ route('posts.index', ['category' => request('category')]) }}" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-r-md transition-colors flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="container mx-auto px-4 max-w-7xl">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow">
                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative aspect-video overflow-hidden bg-gray-100">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center text-xs text-gray-500 mb-3 gap-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $post->published_at->translatedFormat('d F Y') }}
                                </span>
                                <!-- Simulated Category Badge -->
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Berita
                                </span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mb-3">
                                <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $post->title }}</h2>
                            </a>
                            <p class="text-gray-600 mb-4 line-clamp-3 text-sm flex-grow">
                                {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center mt-auto text-sm">
                                Baca selengkapnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-12 text-center border border-gray-200">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Berita Ditemukan</h3>
                    @if(request('search'))
                        <p class="text-gray-600 mb-4">Tidak ada berita yang cocok dengan kata kunci "{{ request('search') }}".</p>
                        <a href="{{ route('posts.index') }}" class="text-blue-600 font-medium hover:underline">Hapus pencarian</a>
                    @else
                        <p class="text-gray-600">Belum ada berita yang dipublikasikan saat ini.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.public>

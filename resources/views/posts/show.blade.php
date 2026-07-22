<x-layouts.public
    :title="($post->seo_title ?: $post->title) . ' - Bandara Kalimarau'"
    :description="$post->seo_description ?: ($post->excerpt ?: str($post->content)->stripTags()->limit(155)->toString())"
    :canonical="route('posts.show', $post->slug)"
    :image="$post->featured_image_url ?? asset('images/logo-header.png')"
    type="article"
    :robots="($preview ?? false) ? 'noindex, nofollow' : null"
>
    @if($preview ?? false)
        <div class="bg-amber-100 border-b border-amber-300 py-3 text-center text-sm font-medium text-amber-900">Pratinjau admin. Konten ini belum tersedia untuk publik.</div>
    @endif
    <div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Breadcrumb -->
            <x-breadcrumb :items="[
                ['label' => 'Beranda', 'url' => route('home')],
                ['label' => 'Berita', 'url' => route('posts.index')],
                ['label' => $post->title, 'class' => 'truncate max-w-[200px] md:max-w-md inline-block'],
            ]" />
        </div>
    </div>

    <article class="pt-12 pb-24 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl transition-all duration-1000 ease-out transform"
             :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
             
            <header class="mb-10 text-center md:text-left">
                <h1 class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6">{{ $post->title }}</h1>
                <div class="h-1.5 w-20 bg-gold-light rounded-full mb-6 mx-auto md:mx-0"></div>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start text-sm text-gray-500 gap-4 pb-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $post->published_at?->translatedFormat('d F Y') ?? 'Belum dipublikasikan' }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $post->author->name ?? 'Admin Kalimarau' }}
                    </div>
                    <div class="flex items-center ml-auto">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gold/10 text-gold-dark">
                            Berita
                        </span>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            @if($post->featured_image_url)
                <figure class="mb-10 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-auto object-cover max-h-[600px]">
                </figure>
            @endif

            <!-- Content Area -->
            <div class="prose prose-lg prose-blue max-w-none text-gray-800">
                {!! $post->content !!}
            </div>
            
            <!-- Simple Share Buttons -->
            <div class="mt-12 pt-6 border-t border-gray-200 flex items-center">
                <span class="font-medium text-gray-700 mr-4">Bagikan:</span>
                <div class="flex space-x-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors" aria-label="Share to Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors" aria-label="Share to Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors" aria-label="Share to WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </article>

    @if($relatedPosts->count() > 0)
    <section class="py-12 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="subsection-title mb-8">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <a href="{{ route('posts.show', $related->slug) }}" class="block overflow-hidden bg-gray-100 aspect-video relative">
                        @if($related->featured_image_url)
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <span class="text-xs text-gray-500 mb-2 block">{{ $related->published_at->translatedFormat('d M Y') }}</span>
                        <a href="{{ route('posts.show', $related->slug) }}" class="block">
                            <h3 class="font-bold text-navy group-hover:text-sky transition-colors line-clamp-2 text-sm">{{ $related->title }}</h3>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.public>

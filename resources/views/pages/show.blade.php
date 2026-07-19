<x-layouts.public
    :title="($page->seo_title ?: $page->title) . ' - Bandara Kalimarau'"
    :description="$page->seo_description ?: ($page->excerpt ?: str($page->content)->stripTags()->limit(155)->toString())"
    :canonical="route('pages.show', $page->slug)"
    :image="$page->featured_image_url ?? asset('images/logo-header.png')"
    :robots="($preview ?? false) ? 'noindex, nofollow' : null"
>
    @if($preview ?? false)
        <div class="bg-amber-100 border-b border-amber-300 py-3 text-center text-sm font-medium text-amber-900">Pratinjau admin. Konten ini belum tersedia untuk publik.</div>
    @endif
    <div class="bg-gray-50 py-6 border-b border-gray-200">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Breadcrumb -->
            <nav class="text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li>
                        <span class="text-gray-800 font-medium truncate max-w-[200px] md:max-w-md inline-block" aria-current="page">{{ $page->title }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <article class="py-12 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
        <div class="container mx-auto px-4 max-w-4xl transition-all duration-700 ease-out"
             :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
             
            <header class="mb-10 text-center md:text-left">
                <h1 class="font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-6">{{ $page->title }}</h1>
                <div class="h-1.5 w-20 bg-gold-light rounded-full mb-6 mx-auto md:mx-0"></div>
                @if($page->excerpt)
                    <p class="text-xl text-gray-500 leading-relaxed">{{ $page->excerpt }}</p>
                @endif
            </header>

            @if($page->featured_image_url)
                <figure class="mb-12 rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 shadow-sm relative group">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto object-cover max-h-[500px] transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-2xl"></div>
                </figure>
            @endif

            <!-- Content Area -->
            <div class="prose prose-lg prose-blue max-w-none text-gray-800
                        prose-p:leading-relaxed prose-a:text-sky prose-a:no-underline hover:prose-a:underline
                        prose-headings:text-navy-dark prose-headings:font-bold
                        first-of-type:prose-p:first-letter:text-6xl first-of-type:prose-p:first-letter:font-bold 
                        first-of-type:prose-p:first-letter:text-navy first-of-type:prose-p:first-letter:float-left 
                        first-of-type:prose-p:first-letter:mr-4 first-of-type:prose-p:first-letter:mt-2 first-of-type:prose-p:first-letter:leading-none">
                {!! $page->content !!}
            </div>

            @if($page->slug === 'profil-bandara-kalimarau')
                @php
                    $awardImages = [
                        '/storage/media/legacy/2022/10/20221024_093158-scaled.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100158_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100119_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100043_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100150_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100110_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100051_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100127_TapScanner-1.jpg',
                        '/storage/media/legacy/2022/10/Screenshot_20221024-100101_TapScanner-1.jpg',
                    ];
                @endphp
                <hr class="my-12 border-gray-200">
                <h2 class="text-3xl font-bold text-navy-dark mb-8 text-center">Penghargaan</h2>
                <x-carousel :images="$awardImages" />
            @endif
        </div>
    </article>
</x-layouts.public>

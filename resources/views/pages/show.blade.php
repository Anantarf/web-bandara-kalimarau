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

    <article class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <header class="mb-8">
                <h1 class="font-sans text-3xl md:text-4xl font-bold text-text-main leading-tight mb-4">{{ $page->title }}</h1>
                @if($page->excerpt)
                    <p class="text-xl text-gray-500">{{ $page->excerpt }}</p>
                @endif
            </header>

            @if($page->featured_image_url)
                <figure class="mb-10 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto object-cover max-h-[500px]">
                </figure>
            @endif

            <!-- Content Area -->
            <div class="prose prose-lg prose-blue max-w-none text-gray-800">
                {!! $page->content !!}
            </div>
        </div>
    </article>
</x-layouts.public>

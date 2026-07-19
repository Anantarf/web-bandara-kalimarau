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

    <article class="pt-12 pb-24 bg-white" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-1000 ease-out transform"
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

            <!-- Content Area with Table of Contents -->
            @php
                // Extract H2 headings for Table of Contents
                preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $page->content, $matches);
                $headings = [];
                foreach($matches[1] as $headingText) {
                    $headings[] = [
                        'text' => strip_tags($headingText),
                        'id' => \Illuminate\Support\Str::slug(strip_tags($headingText))
                    ];
                }
                
                // Add IDs to H2 tags in the content so we can link to them
                $contentWithIds = preg_replace_callback('/<h2([^>]*)>(.*?)<\/h2>/i', function($m) {
                    $existingAttrs = $m[1];
                    $id = \Illuminate\Support\Str::slug(strip_tags($m[2]));
                    
                    // Add standard classes
                    $newClasses = 'scroll-mt-32 border-b-2 border-gray-100 pb-2';
                    
                    if (strpos($existingAttrs, 'class="') !== false) {
                        $attrs = preg_replace('/class="/', 'class="' . $newClasses . ' ', $existingAttrs);
                    } else {
                        $attrs = $existingAttrs . ' class="' . $newClasses . '"';
                    }
                    
                    return "<h2 id=\"{$id}\"{$attrs}>{$m[2]}</h2>";
                }, $page->content);
            @endphp

            <div class="flex flex-col lg:flex-row lg:items-start gap-12 relative" x-data="{ activeSection: '' }" @scroll.window="
                let sections = document.querySelectorAll('h2[id]');
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 150) {
                        current = section.getAttribute('id');
                    }
                });
                activeSection = current;
            ">
                <!-- Main Content -->
                <div class="w-full @if(count($headings) > 1) lg:w-3/4 @endif">
                    <div class="prose prose-lg prose-blue text-gray-800
                                prose-p:leading-relaxed prose-a:text-sky prose-a:no-underline hover:prose-a:underline
                                prose-headings:text-navy-dark prose-headings:font-bold
                                prose-li:marker:text-gold prose-ul:space-y-1">
                        {!! $contentWithIds !!}
                    </div>
                </div>

                <!-- Table of Contents Sidebar -->
                @if(count($headings) > 1)
                    <div class="hidden lg:block lg:w-1/4 relative">
                        <div class="sticky top-32 bg-gray-100/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-sm lg:-mt-2">
                            <h4 class="text-sm font-bold text-navy-dark uppercase tracking-wider mb-4">Daftar Isi</h4>
                            <ul class="space-y-3 text-sm">
                                @foreach($headings as $heading)
                                    <li>
                                        <a href="#{{ $heading['id'] }}" 
                                           class="block transition-colors duration-200 hover:text-gold"
                                           :class="activeSection === '{{ $heading['id'] }}' ? 'text-gold font-bold translate-x-1' : 'text-gray-500'">
                                            {{ $heading['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
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
                <div class="mt-16 bg-gradient-to-br from-white via-white to-blue-50/40 rounded-3xl p-6 md:p-8 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="w-full md:w-1/3 text-center md:text-left">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gold/10 text-gold-dark mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-navy-dark mb-3">Penghargaan & Prestasi</h2>
                            <p class="text-gray-600 text-sm leading-relaxed">Komitmen UPBU Kalimarau terhadap standar pelayanan prima secara konsisten diwujudkan melalui berbagai pencapaian dan penghargaan bergengsi tingkat nasional.</p>
                        </div>
                        <div class="w-full md:w-2/3">
                            <x-carousel :images="$awardImages" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </article>
</x-layouts.public>

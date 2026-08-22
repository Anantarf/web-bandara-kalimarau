@props(['mitra'])

<!-- Section: Mitra Terkemuka -->
    <section class="py-16 lg:py-24 bg-surface overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="font-sans text-3xl font-extrabold tracking-tight text-navy">Dipercaya oleh Mitra Terkemuka</h2>
                <p class="text-text-muted text-base mt-2">Kami bekerja sama dengan berbagai maskapai yang melayani rute langsung dan regional dari Bandara Kalimarau.</p>
            </div>

            <div class="partner-marquee" aria-label="Daftar maskapai mitra Bandara Kalimarau">
                <div class="partner-marquee__track">
                    @foreach(collect($mitra)->concat($mitra) as $item)
                        <div class="partner-marquee__item partner-marquee__item--{{ $item['slug'] }}" title="{{ $item['nama'] }}: {{ $item['rute'] }}">
                            @if($item['logo'])
                                <img src="{{ asset($item['logo']) }}" alt="{{ $item['nama'] }}" loading="lazy" decoding="async" class="partner-marquee__logo">
                            @else
                                <span class="partner-marquee__fallback">{{ $item['nama'] }}</span>
                            @endif
                            <span class="sr-only">{{ $item['nama'] }} melayani rute {{ $item['rute'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

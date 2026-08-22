@props(['sambutan'])

<!-- Section: Sambutan -->
    <section class="bg-surface py-12 lg:py-14 relative z-0">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-[1fr_300px] gap-8 lg:gap-12 items-start scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out">
                <div class="max-w-[70ch]">
                    <h2 class="font-sans text-lg md:text-xl font-bold text-navy uppercase tracking-wide mb-5">Sambutan dari Kepala Bandar Udara</h2>

                    <div class="space-y-5 text-text-muted">
                        @foreach($sambutan['teks'] as $paragraph)
                            <p class="font-sans italic text-lg md:text-[1.15rem] leading-[1.75] text-pretty">"{{ $paragraph }}"</p>
                        @endforeach
                    </div>

                </div>

                <div class="w-full max-w-[280px] lg:max-w-none mx-auto lg:mx-0">
                    <div class="aspect-[4/5] rounded-xl overflow-hidden bg-white shadow-[0_22px_44px_-18px_rgba(12,45,107,0.22)]">
                        <img src="{{ $sambutan['foto'] }}" alt="{{ $sambutan['nama'] }}" loading="lazy" decoding="async" class="w-full h-full object-cover object-[50%_18%]">
                    </div>
                    <div class="mt-2.5 text-center lg:text-left">
                        <h3 class="font-sans text-base md:text-[1.02rem] font-extrabold text-navy leading-snug">{{ $sambutan['nama'] }}</h3>
                        <p class="text-text-muted text-sm md:text-[0.88rem] leading-snug mt-1 lg:whitespace-nowrap">{{ $sambutan['jabatan'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

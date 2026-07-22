<footer class="bg-navy-dark text-white/70">
    <div class="max-w-7xl mx-auto px-4 py-16 md:py-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            <!-- Brand -->
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-white/5 rounded-2xl border border-white/10 shadow-lg">
                        <img src="{{ asset('images/logo-blu.png') }}" alt="Bandara Kalimarau" class="h-12 w-auto object-contain" onerror="this.src='https://placehold.co/150x50?text=Kalimarau'">
                    </div>
                    <div>
                        <div class="text-white font-extrabold text-xl tracking-wide leading-tight">Bandara Kalimarau</div>
                        <div class="text-gold-light/90 font-medium text-xs mt-1 uppercase tracking-wider">Kab. Berau, Kaltim</div>
                    </div>
                </div>
                <address class="not-italic text-sm leading-relaxed mb-4">
                    Teluk Bayur, 77315<br>
                    Kabupaten Berau<br>
                    Kalimantan Timur
                </address>
                <a href="tel:085262146214" class="flex items-center gap-1.5 hover:text-white transition-colors text-sm w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.265-3.965-6.861-6.86l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                    0852 6214 6214
                </a>
            </div>

            <!-- Navigasi -->
            <div>
                <h4 class="text-white font-bold text-base tracking-wide mb-3">Navigasi</h4>
                <div class="h-1 w-10 bg-gold-light rounded-full mb-6"></div>
                <ul class="space-y-3.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Beranda</a></li>
                    <li><a href="{{ route('pages.show', 'profil-bandara-kalimarau') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Profil Bandara</a></li>
                    <li><a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Fasilitas Bandara</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Berita</a></li>
                    <li><a href="{{ route('ppid.show') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">PPID</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div>
                <h4 class="text-white font-bold text-base tracking-wide mb-3">Layanan</h4>
                <div class="h-1 w-10 bg-gold-light rounded-full mb-6"></div>
                <ul class="space-y-3.5 text-sm">
                    <li><a href="{{ route('flights.index') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Jadwal Penerbangan</a></li>
                    <li><a href="{{ route('pages.show', 'tarif-kebandarudaraan') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Tarif Kebandarudaraan</a></li>
                    <li><a href="{{ route('pages.show', 'standar-pelayanan') }}" class="hover:text-gold-light hover:translate-x-1 inline-block transition-all duration-300">Standar Pelayanan</a></li>
                </ul>
            </div>

            <!-- Tautan Eksternal -->
            <div>
                <h4 class="text-white font-bold text-base tracking-wide mb-3">Tautan Eksternal</h4>
                <div class="h-1 w-10 bg-gold-light rounded-full mb-6"></div>
                <ul class="space-y-3.5 text-sm">
                    @foreach([
                        ['label' => 'Kementerian Perhubungan', 'url' => 'https://dephub.go.id'],
                        ['label' => 'Ditjen Perhubungan Udara', 'url' => 'https://hubud.dephub.go.id'],
                        ['label' => 'AirNav Indonesia', 'url' => 'https://airnav.co.id'],
                        ['label' => 'JDIH Kemenhub', 'url' => 'https://jdih.dephub.go.id'],
                    ] as $link)
                        <li>
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="group/link flex items-center gap-2 hover:text-gold-light hover:translate-x-1 transition-all duration-300 w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/20 group-hover/link:bg-gold-light transition-colors"></span>
                                {{ $link['label'] }}
                                <svg class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/40">
            <span>&copy; {{ date('Y') }} Bandara Kalimarau — UPT Kementerian Perhubungan RI</span>
            <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                <!-- Visitor Counter -->
                @if(isset($visitorStats))
                <div class="group flex items-center bg-white/5 hover:bg-white/10 backdrop-blur-sm rounded-full px-5 py-2.5 border border-white/10 hover:border-gold-light/40 transition-all duration-300 shadow-sm cursor-default" title="Total Pengunjung Website">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gold-light/10 text-gold-light group-hover:scale-110 group-hover:bg-gold-light/20 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-medium uppercase tracking-wider text-white/50 leading-none mb-1">Total Pengunjung</span>
                            <span class="text-white/90 font-bold text-sm leading-none">{{ number_format($visitorStats['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                <a href="{{ route('home') }}" class="hover:text-white/70 transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

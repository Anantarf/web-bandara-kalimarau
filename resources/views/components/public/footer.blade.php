<footer class="bg-navy-dark text-white/70">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            <!-- Brand -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-blu.png') }}" alt="Bandara Kalimarau" class="h-12 w-auto object-contain opacity-90" onerror="this.src='https://via.placeholder.com/150x50?text=Kalimarau'">
                    <div>
                        <div class="text-white font-bold text-lg leading-tight">Bandara Kalimarau</div>
                        <div class="text-white/50 text-xs">Kab. Berau, Kaltim</div>
                    </div>
                </div>
                <address class="not-italic text-sm leading-relaxed mb-4">
                    Teluk Bayur, 77315<br>
                    Kabupaten Berau<br>
                    Kalimantan Timur
                </address>
                <a href="tel:08526214614" class="flex items-center gap-1.5 hover:text-white transition-colors text-sm w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.265-3.965-6.861-6.86l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                    0852 6214 6214
                </a>
            </div>

            <!-- Navigasi -->
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('pages.show', 'profil-bandara-kalimarau') }}" class="hover:text-white transition-colors">Profil Bandara</a></li>
                    <li><a href="{{ route('pages.show', 'fasilitas-bandara') }}" class="hover:text-white transition-colors">Fasilitas Bandara</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-white transition-colors">Berita</a></li>
                    <li><a href="{{ route('ppid.show') }}" class="hover:text-white transition-colors">PPID</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Layanan</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('flights.index') }}" class="hover:text-white transition-colors">Jadwal Penerbangan</a></li>
                    <li><a href="{{ route('pages.show', 'tarif-kebandarudaraan') }}" class="hover:text-white transition-colors">Tarif Kebandarudaraan</a></li>
                    <li><a href="{{ route('pages.show', 'standar-pelayanan') }}" class="hover:text-white transition-colors">Standar Pelayanan</a></li>
                </ul>
            </div>

            <!-- Tautan Eksternal -->
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Tautan Eksternal</h4>
                <ul class="space-y-2.5 text-sm">
                    @foreach([
                        ['label' => 'Kementerian Perhubungan', 'url' => 'https://dephub.go.id'],
                        ['label' => 'Ditjen Perhubungan Udara', 'url' => 'https://hubud.dephub.go.id'],
                        ['label' => 'AirNav Indonesia', 'url' => 'https://airnav.co.id'],
                        ['label' => 'JDIH Kemenhub', 'url' => 'https://jdih.dephub.go.id'],
                    ] as $link)
                        <li>
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors inline-flex items-center gap-1">
                                {{ $link['label'] }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/40">
            <span>&copy; {{ date('Y') }} Bandara Kalimarau — UPT Kementerian Perhubungan RI</span>
            <div class="flex gap-4">
                <a href="{{ route('home') }}" class="hover:text-white/70 transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

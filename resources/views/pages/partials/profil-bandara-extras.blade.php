                @php
                    $awardImages = collect([
                        'storage/media/legacy/2022/10/20221024_093158-scaled.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100158_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100119_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100043_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100150_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100110_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100051_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100127_TapScanner-1.jpg',
                        'storage/media/legacy/2022/10/Screenshot_20221024-100101_TapScanner-1.jpg',
                    ])->map(fn ($path) => asset($path))->all();
                @endphp
                <div class="mt-16 bg-white rounded-2xl p-6 md:p-10 border border-gray-100 shadow-md shadow-navy-dark/5 scroll-mt-32">
                    <div class="text-center mb-10">
                        <h2 id="maklumat-pelayanan" class="text-3xl md:text-4xl font-extrabold text-navy-dark mb-4 scroll-mt-32">Maklumat Pelayanan</h2>
                        <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
                        <p class="text-text-muted max-w-2xl mx-auto text-lg leading-relaxed">Komitmen UPBU Kelas I Kalimarau untuk memberikan pelayanan yang transparan, akuntabel, dan sesuai standar mutu bagi seluruh pengguna jasa bandar udara.</p>
                    </div>

                    <x-lightbox-image
                        src="{{ asset('images/maklumat-pelayanan-2026.jpeg') }}"
                        alt="Maklumat Pelayanan Bandar Udara Kalimarau"
                        figure-class="max-w-2xl mx-auto" />

                    <!-- Previous Maklumat Archive Cards -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <!-- Maklumat 2025 -->
                        <a href="{{ asset('images/maklumat-pelayanan-2025.jpeg') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group flex items-center justify-between w-full sm:w-80 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold/10 text-gold-dark shadow-sm">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gold-dark/80">Arsip Maklumat</p>
                                    <h3 class="text-base font-extrabold text-navy-dark group-hover:text-gold transition-colors">Maklumat Pelayanan 2025</h3>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-text-muted/70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <!-- Maklumat 2023 -->
                        <a href="{{ asset('storage/media/legacy/2023/01/maklumat-pelayanan-2023.jpg') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group flex items-center justify-between w-full sm:w-80 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gold/10 text-gold-dark shadow-sm">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gold-dark/80">Arsip Maklumat</p>
                                    <h3 class="text-base font-extrabold text-navy-dark group-hover:text-gold transition-colors">Maklumat Pelayanan 2023</h3>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-text-muted/70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="mt-16 bg-white rounded-2xl p-6 md:p-10 border border-gray-100 shadow-md shadow-navy-dark/5">
                    <div class="text-center mb-10">
                        <h2 id="penghargaan-prestasi" class="text-3xl md:text-4xl font-extrabold text-navy-dark mb-4 scroll-mt-32">Penghargaan & Prestasi</h2>
                        <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
                        <p class="text-text-muted max-w-2xl mx-auto text-lg leading-relaxed">Komitmen UPBU Kalimarau terhadap standar pelayanan prima secara konsisten diwujudkan melalui berbagai pencapaian dan penghargaan bergengsi tingkat nasional.</p>
                    </div>

                    <div class="max-w-4xl mx-auto">
                        <x-carousel :images="$awardImages" />
                    </div>
                </div>

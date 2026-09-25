                            <div class="w-full mb-10">
                                <!-- Survey Cards: 2-Column Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12">
                                    <!-- Card 1: Survey Internal Bandara -->
                                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-border-soft/70 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
                                        <div>
                                            <div class="flex items-center justify-between gap-3 mb-4">
                                                <div class="w-11 h-11 bg-navy/5 text-navy rounded-xl flex items-center justify-center shadow-sm border border-navy/10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-navy/10 text-navy">
                                                    Internal Bandara
                                                </span>
                                            </div>

                                            <h3 class="text-base sm:text-lg font-bold text-navy-dark mb-2 leading-snug">
                                                Survey Kepuasan Pengguna Jasa Internal
                                            </h3>
                                            <p class="text-text-muted text-sm leading-relaxed mb-5">
                                                Ulasan dan masukan Anda sangat berarti bagi kami untuk terus berinovasi dan meningkatkan mutu pelayanan di Bandara Kalimarau.
                                            </p>
                                        </div>

                                        <!-- Image Preview Box -->
                                        <div class="bg-surface/70 rounded-xl p-3 mt-auto">
                                            <x-lightbox-image
                                                src="{{ asset('images/survei-internal.jpeg') }}"
                                                alt="Survey Kepuasan Pengguna Jasa Internal"
                                                img-class="w-full h-auto max-h-56 object-contain rounded-lg"
                                                figure-class="w-full text-center m-0" />
                                        </div>
                                    </div>

                                    <!-- Card 2: Survey Kemenhub -->
                                    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-border-soft/70 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between h-full">
                                        <div>
                                            <div class="flex items-center justify-between gap-3 mb-4">
                                                <div class="w-11 h-11 bg-navy/5 text-navy rounded-xl flex items-center justify-center shadow-sm border border-navy/10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gold/15 text-gold-ink">
                                                    Kemenhub RI
                                                </span>
                                            </div>

                                            <h3 class="text-base sm:text-lg font-bold text-navy-dark mb-2 leading-snug">
                                                Survey Kepuasan Masyarakat Kemenhub
                                            </h3>
                                            <p class="text-text-muted text-sm leading-relaxed mb-5">
                                                Kanal penilaian resmi dari Kementerian Perhubungan untuk mengukur indeks kepuasan pelayanan jasa transportasi udara secara nasional.
                                            </p>
                                        </div>

                                        <!-- Image Preview Box -->
                                        <div class="bg-surface/70 rounded-xl p-3 mt-auto">
                                            <x-lightbox-image
                                                src="{{ asset('images/survei-kemenhub.png') }}"
                                                alt="Survey Kepuasan Masyarakat Kementerian Perhubungan"
                                                img-class="w-full h-auto max-h-56 object-contain rounded-lg"
                                                figure-class="w-full text-center m-0" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Hasil & Tindak Lanjut Survey -->
                                <div id="hasil-survei" class="scroll-mt-28 md:scroll-mt-32 pt-6 border-t border-border-soft/70">
                                    <div class="flex items-center gap-2.5 mb-2">
                                        <div class="w-1.5 h-6 bg-gold rounded-full"></div>
                                        <h3 class="text-xl md:text-2xl font-extrabold text-navy-dark">Hasil & Tindak Lanjut Survey Bulanan</h3>
                                    </div>
                                    @include('pages.partials.hasil-dan-tindak-lanjut')
                                </div>
                            </div>

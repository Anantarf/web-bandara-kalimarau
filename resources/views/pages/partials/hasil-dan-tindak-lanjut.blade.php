                            <div class="mb-12">
                                <p class="text-text-muted mb-10 text-lg leading-relaxed max-w-3xl">
                                    Berikut adalah kumpulan dokumen laporan berkala mengenai hasil survei kepuasan masyarakat terhadap pelayanan publik di UPBU Kelas I Kalimarau. Anda dapat mengakses seluruh rincian laporannya melalui tautan di bawah ini:
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-6">
                                    @php
                                        $dokumenSurvei = [
                                            [
                                                'title' => 'Bulan Agustus 2024',
                                                'link' => 'https://drive.google.com/file/d/168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p/view?usp=sharing',
                                                'id' => '168c9qLjIMP5Yv_HnxIOFwJbuDjzdPB9p'
                                            ],
                                            [
                                                'title' => 'Bulan Juli 2024',
                                                'link' => 'https://drive.google.com/file/d/1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3/view?usp=sharing',
                                                'id' => '1RHBFHchoTMFc33gAcOBgJCcPFwFcMYe3'
                                            ],
                                            [
                                                'title' => 'Bulan Juni 2024',
                                                'link' => 'https://drive.google.com/file/d/1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77/view?usp=sharing',
                                                'id' => '1hLnJ738R6mVgTcgQ9GlqtrMGRomChR77'
                                            ],
                                            [
                                                'title' => 'Bulan Mei 2024',
                                                'link' => 'https://drive.google.com/file/d/1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9/view?usp=sharing',
                                                'id' => '1hjCbhhY7CUZOfFM0FmToHr41gQ3N8ew9'
                                            ],
                                            [
                                                'title' => 'Bulan April 2024',
                                                'link' => 'https://drive.google.com/file/d/1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_/view?usp=sharing',
                                                'id' => '1EYX-1kbv4OSNimhUJdQOCg7DWHib5_T_'
                                            ],
                                            [
                                                'title' => 'Bulan Maret 2024',
                                                'link' => 'https://drive.google.com/file/d/1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP/view?usp=sharing',
                                                'id' => '1JQgLUwKlN69EnzPcsEJwgqkqKa_S6EwP'
                                            ],
                                            [
                                                'title' => 'Bulan Februari 2024',
                                                'link' => 'https://drive.google.com/file/d/1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q/view?usp=sharing',
                                                'id' => '1s8wSZm7n4fZ5YfKIpk2N8QC9z1Cl7U8q'
                                            ],
                                            [
                                                'title' => 'Bulan Januari 2024',
                                                'link' => 'https://drive.google.com/file/d/1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213/view?usp=sharing',
                                                'id' => '1nlemN1rV8VjG_Kq75jljY8Q6jAvgb213'
                                            ],
                                        ];
                                    @endphp

                                    @foreach($dokumenSurvei as $doc)
                                        <a href="{{ $doc['link'] }}" target="_blank" class="group flex flex-col bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                            <!-- Thumbnail Section -->
                                            <div class="relative w-full aspect-[3/4] bg-gray-50 flex items-center justify-center overflow-hidden border-b border-gray-100">
                                                <img src="https://drive.google.com/thumbnail?id={{ $doc['id'] }}&sz=w800"
                                                     alt="Cover Survei {{ $doc['title'] }}"
                                                     class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/600x800/f8fafc/94a3b8?text=Laporan+Survei'; this.className='w-full h-full object-cover opacity-50';"
                                                     loading="lazy">

                                                <!-- Overlay on hover -->
                                                <div class="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/10 transition-colors duration-300"></div>

                                                <!-- View Icon overlay -->
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 scale-90 group-hover:scale-100">
                                                    <div class="bg-white/95 backdrop-blur-sm w-14 h-14 rounded-full flex items-center justify-center text-navy-dark shadow-xl">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Content Section -->
                                            <div class="p-6 flex-1 flex flex-col justify-center items-center text-center relative bg-white">
                                                <div class="absolute -top-6 bg-white p-2 rounded-full shadow-sm border border-gray-50">
                                                    <div class="w-10 h-10 bg-gold-light/20 text-gold-dark rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    </div>
                                                </div>

                                                <h4 class="font-bold text-navy-dark group-hover:text-gold transition-colors duration-300 mb-2 mt-4 leading-snug text-lg">Hasil Survei Kepuasan Masyarakat</h4>
                                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-text-muted rounded-full text-sm font-semibold border border-gray-100">
                                                    <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ $doc['title'] }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

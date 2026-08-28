@props([
    'flightSchedules',
    'mitra',
])

<!-- Section 4: Jadwal Penerbangan Ringkas -->
    @php
        $flightLogos = collect($mitra)->pluck('logo', 'nama')->toArray();
    @endphp
    <section class="bg-navy-dark py-16 lg:py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out delay-100"
             x-data="{
                tab: 'kedatangan',
                flights: {{ \Illuminate\Support\Js::from($flightSchedules->map(function ($f) use ($flightLogos) {
                    return [
                        'type' => $f->type,
                        'airline' => $f->airline,
                        'logo' => isset($flightLogos[$f->airline]) ? asset($flightLogos[$f->airline]) : null,
                        'initials' => collect(explode(' ', $f->airline))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode(''),
                        'flight_number' => $f->flight_number ?? '-',
                        'route' => $f->type === 'keberangkatan' ? $f->route_to : $f->route_from,
                        'time' => ($f->type === 'keberangkatan' ? $f->departure_time : $f->arrival_time)?->format('H:i') ?? '-',
                    ];
                })) }},
                get filteredFlights() {
                    return this.flights.filter(f => f.type === this.tab).slice(0, 5);
                }
             }">

            <!-- Section Title -->
            <div class="text-center mb-8">
                <h2 class="font-sans text-3xl md:text-4xl font-extrabold tracking-tight text-white mb-2">Jadwal Penerbangan</h2>
                <p class="text-white/70 text-base mt-2">Informasi keberangkatan dan kedatangan terkini</p>
            </div>

            <!-- Header Toggle -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex rounded-full p-1 bg-white/5 border border-white/10 shadow-inner">
                    <button type="button" @click="tab = 'kedatangan'" :class="tab === 'kedatangan' ? 'bg-gold text-navy-dark shadow-md' : 'text-white/70 hover:text-white'" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        <x-icon-arrow class="w-4 h-4 transform rotate-45" />
                        Kedatangan
                    </button>
                    <button type="button" @click="tab = 'keberangkatan'" :class="tab === 'keberangkatan' ? 'bg-gold text-navy-dark shadow-md' : 'text-white/70 hover:text-white'" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                        <x-icon-arrow class="w-4 h-4 transform -rotate-45" />
                        Keberangkatan
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="min-w-[720px]">
                    <!-- Table Header -->
                    <div class="hidden md:grid grid-cols-[1.3fr_2.6fr_1fr_1fr] gap-4 px-8 py-3 text-white/50 text-xs font-bold tracking-wide uppercase mb-2">
                        <div>Maskapai</div>
                        <div x-text="tab === 'kedatangan' ? 'Dari' : 'Tujuan'"></div>
                        <div>Nomor</div>
                        <div>Waktu</div>
                    </div>

                    <div x-show="filteredFlights.length === 0" style="display: none;" class="px-6 py-12 text-center text-white/50 bg-white/5 rounded-2xl border border-white/10">
                        <p class="text-base font-medium">Belum ada jadwal aktif saat ini.</p>
                    </div>

                    <!-- Table Rows -->
                    <div x-show="filteredFlights.length > 0" class="flex flex-col gap-3 md:gap-2">
                        <template x-for="(flight, index) in filteredFlights" :key="tab + index">
                            <div class="flex flex-col md:grid md:grid-cols-[1.3fr_2.6fr_1fr_1fr] gap-3 md:gap-4 items-start md:items-center px-5 md:px-6 py-4 bg-[#14233a] rounded-xl hover:bg-[#1a2c49] transition-colors shadow-sm border border-white/5 md:border-transparent">

                                <!-- Top Area (Mobile) -->
                                <div class="flex items-center gap-4 w-full md:contents">
                                    <!-- Maskapai -->
                                    <div class="flex items-center shrink-0">
                                        <template x-if="flight.logo">
                                            <div class="w-16 md:w-24 h-10 md:h-12 bg-white rounded-md p-1.5 md:p-2 shadow-sm flex items-center justify-center">
                                                <img :src="flight.logo" :alt="flight.airline" class="max-w-full max-h-full object-contain">
                                            </div>
                                        </template>
                                        <template x-if="!flight.logo">
                                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-sm font-bold text-white" x-text="flight.initials" :title="flight.airline"></div>
                                        </template>
                                    </div>

                                    <!-- Rute -->
                                    <div class="font-bold text-white text-base md:text-base leading-snug flex-1 min-w-0">
                                        <div class="md:hidden text-white/45 text-xs font-medium uppercase tracking-wide mb-0.5" x-text="tab === 'kedatangan' ? 'Kedatangan Dari' : 'Keberangkatan Ke'"></div>
                                        <span class="truncate block" x-text="flight.route"></span>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="w-full h-px bg-white/5 md:hidden my-0.5"></div>

                                <!-- Bottom Area (Mobile) -->
                                <div class="flex items-center justify-between w-full md:contents">
                                    <!-- Nomor -->
                                    <div class="text-white/70 text-sm md:text-base font-medium whitespace-nowrap">
                                        <span class="md:hidden text-white/45 text-xs font-medium uppercase tracking-wide block mb-0.5">Nomor Penerbangan</span>
                                        <span x-text="flight.flight_number"></span>
                                    </div>

                                    <!-- Waktu -->
                                    <div class="font-bold text-white tabular-nums whitespace-nowrap text-right md:text-left">
                                        <span class="md:hidden text-white/45 text-xs font-medium uppercase tracking-wide block mb-0.5">Waktu</span>
                                        <span class="text-xl md:text-base text-gold md:text-white" x-text="flight.time"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('flights.index') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full border border-gold text-gold hover:bg-gold hover:text-navy font-semibold transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                    Lihat Jadwal Lengkap
                </a>
            </div>
        </div>
    </section>

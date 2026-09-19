<x-layouts.public
    title="Jadwal Penerbangan - Bandara Kalimarau"
    description="Informasi jadwal keberangkatan dan kedatangan pesawat di Bandara Kalimarau."
    :canonical="route('flights.index')"
>
    <x-page-header
        title="Jadwal Penerbangan"
        description="Informasi jadwal keberangkatan dan kedatangan pesawat di Bandara Kalimarau."
        container-class="max-w-7xl mx-auto px-4"
        :breadcrumbs="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Jadwal Penerbangan'],
        ]" />

    <div class="pb-12 pt-4 bg-white min-h-[500px]">
        <div class="max-w-7xl mx-auto px-4">
            @php
                $dayLabels = ['senin' => 'Sen', 'selasa' => 'Sel', 'rabu' => 'Rab', 'kamis' => 'Kam', 'jumat' => 'Jum', 'sabtu' => 'Sab', 'minggu' => 'Min'];
                $airlineInitials = fn (string $name) => collect(explode(' ', $name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('');
                $operatingDays = function ($flight) use ($dayLabels) {
                    if (empty($flight->days) || count($flight->days) === 7) return 'Setiap Hari';
                    return collect($flight->days)->map(fn ($d) => $dayLabels[$d] ?? $d)->implode(', ');
                };
                $allAirlines = $arrivals->concat($departures)->pluck('airline')->unique()->filter()->sort()->values();
            @endphp

            <div class="bg-navy-dark rounded-2xl overflow-hidden shadow-xl transition duration-300 ease-out transform"
                 x-data="{
                    tab: 'kedatangan',
                    loaded: false,
                    searchQuery: '',
                    selectedAirline: '',
                    matches(airline, route, number) {
                        const q = this.searchQuery.toLowerCase().trim();
                        const matchAirline = !this.selectedAirline || airline.toLowerCase() === this.selectedAirline.toLowerCase();
                        const matchQuery = !q || airline.toLowerCase().includes(q) || route.toLowerCase().includes(q) || (number && number.toLowerCase().includes(q));
                        return matchAirline && matchQuery;
                    },
                    resetFilters() {
                        this.searchQuery = '';
                        this.selectedAirline = '';
                    }
                 }"
                 x-init="setTimeout(() => loaded = true, 100)"
                 :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">

                <!-- Header Controls: Tabs & Filter Bar -->
                <div class="p-4 sm:p-6 border-b border-white/10 space-y-4">
                    <!-- Pill toggle tabs -->
                    <div class="flex justify-center gap-3">
                        <button type="button" @click="tab = 'kedatangan'" :class="tab === 'kedatangan' ? 'bg-gold text-navy-dark shadow-md' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                            <svg class="w-4 h-4 rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            Kedatangan
                        </button>
                        <button type="button" @click="tab = 'keberangkatan'" :class="tab === 'keberangkatan' ? 'bg-gold text-navy-dark shadow-md' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold">
                            <svg class="w-4 h-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            Keberangkatan
                        </button>
                    </div>

                    <!-- Filter Controls (Search & Airline Select) -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2 max-w-3xl mx-auto">
                        <div class="sm:col-span-7 relative">
                            <input
                                type="text"
                                x-model="searchQuery"
                                placeholder="Cari kota rute, nomor, atau maskapai..."
                                class="w-full bg-white/10 border border-white/15 rounded-xl px-4 py-2.5 pl-10 text-sm text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent transition-all">
                            <svg class="w-4 h-4 text-white/40 absolute left-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <button x-show="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-3 text-white/40 hover:text-white" title="Hapus pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="sm:col-span-5 relative">
                            <select
                                x-model="selectedAirline"
                                class="w-full bg-white/10 border border-white/15 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent transition-all appearance-none cursor-pointer">
                                <option value="" class="bg-navy-dark text-white">Semua Maskapai</option>
                                @foreach($allAirlines as $airlineName)
                                    <option value="{{ $airlineName }}" class="bg-navy-dark text-white">{{ $airlineName }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kedatangan -->
                <div x-show="tab === 'kedatangan'" class="w-full"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    @if($arrivals->isEmpty())
                        <div class="py-20 px-4 text-center">
                            <h3 class="text-xl font-bold text-white mb-2">Belum ada jadwal aktif</h3>
                            <p class="text-white/50 max-w-md mx-auto">Data jadwal kedatangan penerbangan sedang dalam proses pembaruan dari maskapai terkait.</p>
                        </div>
                    @else
                        <div class="md:hidden px-4 py-2 text-right text-xs text-gold/80 font-medium flex items-center justify-end gap-1 border-b border-white/5">
                            <span>Geser tabel ke samping</span>
                            <svg class="w-3.5 h-3.5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[720px]">
                                <thead>
                                    <tr class="text-white/50 text-xs uppercase tracking-wide">
                                        <th class="py-4 px-6 font-semibold">Maskapai</th>
                                        <th class="py-4 px-6 font-semibold">Dari</th>
                                        <th class="py-4 px-6 font-semibold">Nomor</th>
                                        <th class="py-4 px-6 font-semibold">Waktu</th>
                                        <th class="py-4 px-6 font-semibold">Keterangan</th>
                                        <th class="py-4 px-6 font-semibold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($arrivals as $flight)
                                        <tr x-show="matches('{{ addslashes($flight->airline) }}', '{{ addslashes($flight->route_from) }}', '{{ addslashes($flight->flight_number ?? '') }}')"
                                            class="hover:bg-white/5 transition-colors">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    @if(isset($logos[$flight->airline]))
                                                        <div class="w-20 md:w-24 h-10 md:h-12 bg-white rounded-md p-2 shadow-sm flex items-center justify-center shrink-0">
                                                            <img src="{{ $logos[$flight->airline] }}" alt="{{ $flight->airline }}" class="max-w-full max-h-full object-contain">
                                                        </div>
                                                    @else
                                                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-sm font-bold text-white shrink-0" title="{{ $flight->airline }}">{{ $airlineInitials($flight->airline) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 font-bold text-white uppercase text-sm">{{ $flight->route_from }}</td>
                                            <td class="py-4 px-6 text-white/60 tabular-nums text-sm font-medium">{{ $flight->flight_number ?: '-' }}</td>
                                            <td class="py-4 px-6 font-bold text-white tabular-nums">{{ $flight->arrival_time?->format('H:i') ?? '-' }} <span class="text-white/40 text-xs font-normal">WITA</span></td>
                                            <td class="py-4 px-6 text-white/50 text-sm">{{ $operatingDays($flight) }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <span class="inline-block bg-success/15 text-success-soft text-xs font-bold px-3 py-1 rounded-full">Terjadwal</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Keberangkatan -->
                <div x-show="tab === 'keberangkatan'" x-cloak class="w-full"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    @if($departures->isEmpty())
                        <div class="py-20 px-4 text-center">
                            <h3 class="text-xl font-bold text-white mb-2">Belum ada jadwal aktif</h3>
                            <p class="text-white/50 max-w-md mx-auto">Data jadwal keberangkatan penerbangan sedang dalam proses pembaruan dari maskapai terkait.</p>
                        </div>
                    @else
                        <div class="md:hidden px-4 py-2 text-right text-xs text-gold/80 font-medium flex items-center justify-end gap-1 border-b border-white/5">
                            <span>Geser tabel ke samping</span>
                            <svg class="w-3.5 h-3.5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[720px]">
                                <thead>
                                    <tr class="text-white/50 text-xs uppercase tracking-wide">
                                        <th class="py-4 px-6 font-semibold">Maskapai</th>
                                        <th class="py-4 px-6 font-semibold">Tujuan</th>
                                        <th class="py-4 px-6 font-semibold">Nomor</th>
                                        <th class="py-4 px-6 font-semibold">Waktu</th>
                                        <th class="py-4 px-6 font-semibold">Keterangan</th>
                                        <th class="py-4 px-6 font-semibold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($departures as $flight)
                                        <tr x-show="matches('{{ addslashes($flight->airline) }}', '{{ addslashes($flight->route_to) }}', '{{ addslashes($flight->flight_number ?? '') }}')"
                                            class="hover:bg-white/5 transition-colors">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    @if(isset($logos[$flight->airline]))
                                                        <div class="w-20 md:w-24 h-10 md:h-12 bg-white rounded-md p-2 shadow-sm flex items-center justify-center shrink-0">
                                                            <img src="{{ $logos[$flight->airline] }}" alt="{{ $flight->airline }}" class="max-w-full max-h-full object-contain">
                                                        </div>
                                                    @else
                                                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-sm font-bold text-white shrink-0" title="{{ $flight->airline }}">{{ $airlineInitials($flight->airline) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 font-bold text-white uppercase text-sm">{{ $flight->route_to }}</td>
                                            <td class="py-4 px-6 text-white/60 tabular-nums text-sm font-medium">{{ $flight->flight_number ?: '-' }}</td>
                                            <td class="py-4 px-6 font-bold text-white tabular-nums">{{ $flight->departure_time?->format('H:i') ?? '-' }} <span class="text-white/40 text-xs font-normal">WITA</span></td>
                                            <td class="py-4 px-6 text-white/50 text-sm">{{ $operatingDays($flight) }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <span class="inline-block bg-success/15 text-success-soft text-xs font-bold px-3 py-1 rounded-full">Terjadwal</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="bg-white/5 p-4 border-t border-white/10 text-sm text-white/50">
                    <p class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Jadwal penerbangan dapat berubah sewaktu-waktu sesuai dengan kebijakan maskapai penerbangan terkait. Harap hubungi maskapai untuk informasi lebih lanjut.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>

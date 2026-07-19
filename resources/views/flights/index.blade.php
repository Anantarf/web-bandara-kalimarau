<x-layouts.public
    title="Jadwal Penerbangan - Bandara Kalimarau"
    description="Informasi jadwal keberangkatan dan kedatangan pesawat di Bandara Kalimarau."
    :canonical="route('flights.index')"
>
    <!-- Header -->
    <div class="bg-navy-dark text-white py-8 border-b-4 border-gold">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm mb-6 text-white/70" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex flex-wrap">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                        <svg class="fill-current w-3 h-3 mx-2 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li><span class="font-medium text-white" aria-current="page">Jadwal Penerbangan</span></li>
                </ol>
            </nav>

            <h1 class="font-sans text-2xl md:text-4xl font-bold mb-3">Jadwal Penerbangan</h1>
            <p class="text-base text-white/70 max-w-3xl">Informasi jadwal keberangkatan dan kedatangan pesawat di Bandara Kalimarau.</p>
        </div>
    </div>

    <div class="py-12 bg-surface min-h-[500px]">
        <div class="max-w-7xl mx-auto px-4">
            @php
                $dayLabels = ['senin' => 'Sen', 'selasa' => 'Sel', 'rabu' => 'Rab', 'kamis' => 'Kam', 'jumat' => 'Jum', 'sabtu' => 'Sab', 'minggu' => 'Min'];
                $palette = ['#1E6FB5', '#C8860A', '#1A7A4A', '#7A3A1A', '#5A1A7A', '#0C2D6B'];
                $airlineColor = fn (string $name) => $palette[crc32($name) % count($palette)];
                $airlineInitials = fn (string $name) => collect(explode(' ', $name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('');
                $operatingDays = function ($flight) use ($dayLabels) {
                    if (empty($flight->days) || count($flight->days) === 7) return 'Setiap Hari';
                    return collect($flight->days)->map(fn ($d) => $dayLabels[$d] ?? $d)->implode(', ');
                };
            @endphp

            <div class="bg-navy-dark rounded-2xl overflow-hidden shadow-xl" x-data="{ tab: 'kedatangan' }">
                <!-- Pill toggle -->
                <div class="flex justify-center gap-3 py-6 px-4 border-b border-white/10">
                    <button type="button" @click="tab = 'kedatangan'" :class="tab === 'kedatangan' ? 'bg-gold text-navy-dark' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold transition-colors">
                        <svg class="w-4 h-4 rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Kedatangan
                    </button>
                    <button type="button" @click="tab = 'keberangkatan'" :class="tab === 'keberangkatan' ? 'bg-gold text-navy-dark' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold transition-colors">
                        <svg class="w-4 h-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Keberangkatan
                    </button>
                </div>

                <!-- Kedatangan -->
                <div x-show="tab === 'kedatangan'" class="w-full">
                    @if($arrivals->isEmpty())
                        <div class="py-20 px-4 text-center">
                            <h3 class="text-xl font-bold text-white mb-2">Belum ada jadwal aktif</h3>
                            <p class="text-white/50 max-w-md mx-auto">Data jadwal kedatangan penerbangan sedang dalam proses pembaruan dari maskapai terkait.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[720px]">
                                <thead>
                                    <tr class="text-white/50 text-xs uppercase tracking-widest">
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
                                        <tr class="hover:bg-white/5 transition-colors">
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
                                            <td class="py-4 px-6 text-white/50 font-mono text-sm">{{ $flight->flight_number ?: '-' }}</td>
                                            <td class="py-4 px-6 font-bold text-white tabular-nums">{{ $flight->arrival_time?->format('H:i') ?? '-' }} <span class="text-white/40 text-xs font-normal">WITA</span></td>
                                            <td class="py-4 px-6 text-white/50 text-sm">{{ $operatingDays($flight) }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <span class="inline-block bg-emerald-500/20 text-emerald-400 text-xs font-bold px-3 py-1 rounded-full">Terjadwal</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Keberangkatan -->
                <div x-show="tab === 'keberangkatan'" style="display: none;" class="w-full">
                    @if($departures->isEmpty())
                        <div class="py-20 px-4 text-center">
                            <h3 class="text-xl font-bold text-white mb-2">Belum ada jadwal aktif</h3>
                            <p class="text-white/50 max-w-md mx-auto">Data jadwal keberangkatan penerbangan sedang dalam proses pembaruan dari maskapai terkait.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[720px]">
                                <thead>
                                    <tr class="text-white/50 text-xs uppercase tracking-widest">
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
                                        <tr class="hover:bg-white/5 transition-colors">
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
                                            <td class="py-4 px-6 text-white/50 font-mono text-sm">{{ $flight->flight_number ?: '-' }}</td>
                                            <td class="py-4 px-6 font-bold text-white tabular-nums">{{ $flight->departure_time?->format('H:i') ?? '-' }} <span class="text-white/40 text-xs font-normal">WITA</span></td>
                                            <td class="py-4 px-6 text-white/50 text-sm">{{ $operatingDays($flight) }}</td>
                                            <td class="py-4 px-6 text-right">
                                                <span class="inline-block bg-emerald-500/20 text-emerald-400 text-xs font-bold px-3 py-1 rounded-full">Terjadwal</span>
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

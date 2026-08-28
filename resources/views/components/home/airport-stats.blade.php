@props(['airportStat'])

@if($airportStat)
    <section class="bg-white py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out">
            <div class="text-center mb-12">
                <h2 class="font-sans text-3xl md:text-4xl font-extrabold tracking-tight text-navy mb-2">Aktivitas Bandara</h2>
                <p class="text-text-muted text-base mt-2">Statistik pergerakan periode {{ $airportStat->period_name }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <x-home.stat-counter :value="$airportStat->passenger_count" label="Penumpang">
                    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </x-home.stat-counter>
                <x-home.stat-counter :value="$airportStat->flight_count" label="Pergerakan Pesawat">
                    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 21 4s-2 0-3.5 1.5L14 9 5.8 6.2c-.5-.2-1.1 0-1.4.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 4.1c.4.4.9.5 1.3.3l.5-.3c.5-.3.7-.9.5-1.4z"></path></svg>
                </x-home.stat-counter>
                <x-home.stat-counter :value="$airportStat->cargo_count" label="Kargo (Kg)">
                    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </x-home.stat-counter>
            </div>
        </div>
    </section>
@endif
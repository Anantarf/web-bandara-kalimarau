<x-layouts.public
    title="Bandara Kalimarau Berau (BEJ) - Jadwal Penerbangan & Informasi Resmi"
    description="Situs resmi Bandar Udara Kalimarau Berau (BEJ). Cek jadwal kedatangan & keberangkatan pesawat hari ini, fasilitas terminal, layanan penumpang, dan PPID."
    :canonical="route('home')"
    :image="asset('images/hero/hero1.jpg')"
    :preloadImage="asset('images/hero/hero1.webp')"
    :withHeaderPadding="false"
>
    <x-home.hero :hero-images="$heroImages" />

    <x-home.sambutan :sambutan="$sambutan" />

    <x-home.airport-stats :airport-stat="$airportStat" />

    <x-home.flight-summary :flight-schedules="$flightSchedules" :mitra="$mitra" />

    <x-home.facilities :facilities="$facilities" />

    <x-home.faq />

    <x-home.partners :mitra="$mitra" />

    <x-home.latest-news :latest-posts="$latestPosts" />

    <x-home.scroll-animation />

</x-layouts.public>

<x-layouts.public
    title="Bandara Kalimarau - Gerbang Udara Kabupaten Berau"
    description="Website resmi Bandara Kalimarau untuk informasi penerbangan, berita, layanan publik, PPID, kontak, dan pengaduan."
    :canonical="route('home')"
    :image="$heroImages[0]"
    :preloadImage="$heroImages[0]"
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

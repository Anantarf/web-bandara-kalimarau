@php
    $faqs = [
        ['q' => 'Berapa lama saya harus tiba di bandara sebelum keberangkatan?', 'a' => 'Untuk penerbangan domestik, kami menyarankan Anda tiba di bandara minimal 2 jam sebelum waktu keberangkatan yang tertera di tiket. Hal ini untuk memberikan waktu yang cukup untuk proses check-in, penyerahan bagasi, dan pemeriksaan keamanan yang menyeluruh.'],
        ['q' => 'Apakah di Bandara Kalimarau terdapat fasilitas penginapan?', 'a' => 'Saat ini Bandara Kalimarau belum memiliki fasilitas penginapan atau hotel transit di dalam area bandara. Namun, terdapat berbagai pilihan akomodasi dan hotel terkemuka yang hanya berjarak beberapa menit berkendara dari kawasan bandara.'],
        ['q' => 'Bagaimana prosedur jika ada barang saya yang tertinggal atau hilang di bandara?', 'a' => 'Jika Anda merasa barang Anda tertinggal di area bandara (di luar pesawat), silakan segera melapor ke petugas Avsec (Aviation Security) atau menuju meja pusat informasi di terminal kedatangan. Anda juga dapat menghubungi kami melalui halaman Kontak.'],
        ['q' => 'Apakah ada layanan transportasi umum dari/ke bandara?', 'a' => 'Tersedia layanan taksi bandara dan transportasi online yang telah resmi bermitra dengan Bandara Kalimarau. Loket taksi resmi dapat Anda temukan tepat di pintu keluar area kedatangan terminal penumpang.'],
    ];
@endphp

<section class="py-16 lg:py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-4 scroll-animate opacity-100 translate-y-0 transition-all duration-[1000ms] ease-out delay-100">
        <div class="text-center mb-16">
            <h2 class="font-sans text-3xl md:text-4xl font-extrabold tracking-tight text-navy-dark mb-4">Pertanyaan Seputar Bandara</h2>
            <div class="h-1.5 w-20 bg-gold-light mx-auto rounded-full mb-6"></div>
            <p class="text-text-muted text-base md:text-lg">Temukan jawaban untuk pertanyaan yang paling sering diajukan oleh pengunjung kami.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach($faqs as $index => $faq)
                <x-home.faq-item :faq="$faq" :index="$index" />
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-12">
            <a href="{{ route('faq') }}" class="inline-flex justify-center items-center gap-3 px-8 py-3.5 bg-white text-navy border-2 border-navy rounded-full shadow-md hover:bg-navy hover:text-white hover:-translate-y-0.5 transition-all duration-300 group focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-navy">
                <span class="text-sm font-semibold tracking-wide">Lihat Semua FAQ</span>
                <x-icon-arrow class="w-4 h-4 text-navy group-hover:text-gold-light group-hover:translate-x-1 transition-all" />
            </a>
            <a href="{{ route('contact.index') }}" class="inline-flex justify-center items-center gap-3 px-8 py-3.5 bg-navy text-white rounded-full shadow-lg shadow-navy/20 hover:bg-navy-dark hover:-translate-y-0.5 hover:shadow-xl transition-all duration-300 group focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                <span class="text-sm font-semibold tracking-wide">Punya pertanyaan lain? Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>
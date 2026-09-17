<div class="space-y-8">
    <!-- Info Highlights Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl p-5 border border-border-soft shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-navy flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h3 class="font-bold text-navy-dark text-base mb-1">Kerahasiaan Terjamin</h3>
            <p class="text-text-muted text-xs leading-relaxed">Identitas pelapor dilindungi secara penuh sesuai ketentuan hukum yang berlaku.</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-border-soft shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-gold/10 text-gold-ink flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="font-bold text-navy-dark text-base mb-1">Terintegrasi Kemenhub</h3>
            <p class="text-text-muted text-xs leading-relaxed">Dikelola langsung oleh Inspektorat Jenderal Kementerian Perhubungan Republik Indonesia.</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-border-soft shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="font-bold text-navy-dark text-base mb-1">Penanganan Akuntabel</h3>
            <p class="text-text-muted text-xs leading-relaxed">Progres dan status tindak lanjut pengaduan dapat dipantau secara berkala dan transparan.</p>
        </div>
    </div>

    <!-- Infografis Alur SIMADU Card -->
    <div class="bg-white rounded-2xl p-6 md:p-8 border border-border-soft shadow-sm">
        <div class="text-center max-w-2xl mx-auto mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-navy-dark mb-2">Alur Tata Cara Pengaduan SIMADU</h2>
            <p class="text-text-muted text-sm leading-relaxed">
                Pelajari mekanisme dan tahapan penyampaian laporan pengaduan melalui infografis resmi di bawah ini:
            </p>
        </div>

        <div class="w-full max-w-2xl mx-auto">
            <x-lightbox-image
                src="{{ asset('storage/media/legacy/2022/11/4ba95402a5433595324bab5efc0ec308.png') }}"
                alt="Alur Tata Cara Pengaduan SIMADU"
                figure-class="my-0 text-center" />
        </div>

        <div class="text-center mt-8 pt-6 border-t border-border-soft">
            <a href="https://simadu.dephub.go.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 px-7 py-3 bg-navy hover:bg-navy-dark text-white rounded-xl font-bold text-sm md:text-base shadow-md hover:shadow-lg hover:-translate-y-0.5 transition duration-200 group">
                <span>Akses Portal SIMADU Kemenhub</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
            <p class="text-xs text-text-muted mt-2">Tautan akan membuka website resmi SIMADU Kemenhub di tab baru.</p>
        </div>
    </div>
</div>

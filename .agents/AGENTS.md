# Project Design Guidelines

Berdasarkan instruksi pengguna, halaman **Profil Bandara** dan **Fasilitas Bandara** ditetapkan sebagai **STANDAR UTAMA (Golden Standard)** untuk seluruh antarmuka web di proyek ini.

Jika diminta untuk merapikan atau membuat halaman baru, pastikan untuk selalu mengacu pada standar visual berikut:

1. **Breadcrumb (Navigasi Lokasi)**:
   - Ditempatkan di dalam kontainer berlatar abu-abu terang: `<div class="bg-gray-50 py-4 sm:py-6 border-b border-gray-200">`.
   - Teks menggunakan warna abu-abu `text-gray-500` dan berubah menjadi `hover:text-navy`. 
   - Halaman aktif berwarna lebih gelap `text-gray-800 font-medium`.

2. **Header Judul Halaman (Hero / Header Section)**:
   - Latar belakang wajib **putih bersih** (`bg-white`), *bukan* biru gelap atau warna lain.
   - Tipografi Judul: Menggunakan warna *Navy* berukuran besar dan ekstra tebal (`font-sans text-3xl md:text-5xl font-extrabold text-navy-dark leading-tight mb-4`).
   - Paragraf Deskripsi (opsional): Menggunakan `text-lg text-gray-500` (atau `text-xl`).

3. **Garis Aksen Emas (The Golden Line)**:
   - Wajib ditambahkan tepat di bawah judul utama pada setiap halaman.
   - Kode elemen: `<div class="h-1.5 w-20 bg-gold-light mx-auto md:mx-0 rounded-full mb-6"></div>` (gunakan `bg-gold-light` dan ukuran lebar `w-20`).

4. **Warna Palet Utama**:
   - Primer: Biru Dongker / *Navy* (`navy-dark`, `navy`).
   - Aksen: Emas (`gold-light`, `gold`).
   - Latar Belakang Netral: Putih (`bg-white`) dan Abu-abu Terang (`bg-gray-50`).

5. **Animasi Transisi Masuk (Entry Animation)**:
   - Gunakan Alpine.js untuk memberikan efek muncul secara elegan (*staggered fade-in-up*).
   - Bungkus elemen utama dengan `x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)"`.
   - Gunakan `x-show="loaded"` pada elemen-elemen di dalamnya (seperti *header*, garis emas, konten).
   - Berikan jeda bertahap pada tiap elemen dengan kombinasi `x-transition:enter="transition-all ease-out duration-1000 delay-[Xms]"` (misalnya delay 100ms untuk judul, 300ms untuk garis, dan 500ms untuk konten).

Pastikan semua desain halaman publik yang dirapikan atau dibuat mengikuti kelima kaidah di atas untuk menjaga kesan "premium" dan "elegan".

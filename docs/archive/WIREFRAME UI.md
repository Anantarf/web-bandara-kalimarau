# WIREFRAME UI

## Prinsip

UI harus terlihat seperti website layanan publik bandara yang matang: jelas, tenang, cepat, dan mudah dipakai. Jangan membuat tampilan seperti template AI, landing page startup, atau dashboard yang dipaksa jadi website publik.

Target pengguna utama adalah user awam: penumpang, keluarga penumpang, pemohon layanan, pencari informasi publik, dan staf non-teknis. Prioritas UI adalah menemukan informasi dengan cepat, bukan membuat efek visual yang terlihat "wah".

## Anti AI-Style Rules

- Jangan pakai hero copy yang terlalu marketing.
- Jangan pakai gradient abstrak, orb, glassmorphism, atau dekorasi visual tanpa fungsi.
- Jangan membuat semua section menjadi card.
- Jangan gunakan animasi berlebihan.
- Jangan pakai ilustrasi generik jika foto nyata bandara tersedia.
- Jangan membuat layout terlalu editorial sampai informasi utama tenggelam.
- Jangan membuat tombol terlalu banyak dalam satu section.
- Jangan gunakan istilah teknis untuk user publik.
- Jangan membuat dashboard look untuk halaman publik.
- Jangan meniru Elementor lama.

## UX Untuk User Awam

- Navigasi harus bisa dipahami tanpa membaca instruksi.
- Label menu harus literal dan familiar.
- Informasi kontak, jadwal, layanan, pengaduan, dan PPID harus mudah ditemukan dari homepage.
- Tombol utama maksimal 1-2 per section.
- External link harus terlihat jelas agar user paham akan keluar dari website utama.
- Halaman panjang harus punya heading yang jelas.
- Form harus pendek, validasinya jelas, dan error message mudah dimengerti.
- Mobile harus diprioritaskan karena banyak user kemungkinan membuka dari HP.

## Layout Global

### Header Desktop

- Top strip opsional:
  - alamat singkat atau nama instansi.
  - link kontak.
  - link external penting.
- Main header:
  - logo kiri.
  - nav kanan.
  - search icon.
  - CTA kecil ke "Jadwal Penerbangan" atau "Pengaduan".
- Dropdown:
  - Profil.
  - Pelayanan dan Kerjasama.
  - Pengaduan.

### Header Mobile

- Logo kiri.
- Menu button kanan.
- Menu drawer:
  - semua nav utama.
  - search.
  - CTA layanan.
- Hindari dropdown bertingkat dalam bertingkat. Gunakan group heading.

### Footer

- Logo + nama Bandara Kalimarau.
- Alamat/kontak.
- Link utama.
- Link layanan publik.
- Link pengaduan.
- Copyright.

## Homepage

### Section 1 - Hero

Konten:

- Foto nyata bandara/terminal/pesawat sebagai background atau full-width image.
- H1: `Bandara Kalimarau`
- Subcopy pendek: posisi/lokasi dan fungsi layanan.
- CTA:
  - `Lihat Jadwal Penerbangan`
  - `Layanan Pengaduan`

Catatan desain:

- Jangan pakai gradient abstrak sebagai hero utama.
- Jangan taruh semua text dalam card besar.
- Pastikan gambar tetap jelas di mobile.
- Copy hero cukup informatif; hindari kalimat promosi yang tidak perlu.

### Section 2 - Quick Links

Item:

- Jadwal Penerbangan.
- Pengajuan Pas Bandara.
- Survey Kepuasan.
- PPID.
- Kontak.

Format:

- Grid icon + label.
- Maksimal 5 item di desktop, 2 kolom di mobile.

### Section 3 - Jadwal Penerbangan Ringkas

Komponen:

- Tab: Keberangkatan, Kedatangan.
- Tampilkan 5-8 jadwal aktif.
- Link ke halaman jadwal penuh.

### Section 4 - Berita Terkini

Komponen:

- 1 berita utama besar.
- 4-6 berita kecil.
- Link `Lihat Semua Berita`.

### Section 5 - Fasilitas

Format:

- Gallery/list fasilitas.
- Foto + nama + deskripsi pendek.
- Jangan pakai carousel berat kecuali konten terlalu banyak.

### Section 6 - Unit Kerja

Format:

- Grid unit kerja.
- Nama unit.
- Deskripsi pendek.
- Video YouTube opsional sebagai modal/link.

### Section 7 - Layanan Publik

Format:

- Cards untuk PPID, SIMADU, SP4N Lapor, Survey.
- External link diberi indikator.

## Listing Berita

Header:

- Title `Berita`
- Search input.
- Filter kategori.

Body:

- Grid 3 kolom desktop.
- 1 kolom mobile.
- Card:
  - image.
  - tanggal.
  - kategori.
  - judul.
  - excerpt maksimal 2-3 baris.

Pagination:

- Laravel pagination biasa.
- Jangan infinite scroll.

## Detail Berita

Layout:

- Breadcrumb.
- Judul.
- Meta tanggal dan author.
- Featured image.
- Konten.
- Share button sederhana.
- Related posts.

Konten:

- Bersihkan HTML Elementor.
- Pastikan gambar tidak overflow.
- Heading harus rapi.

## Halaman Statis

Layout:

- Breadcrumb.
- Page title.
- Optional intro.
- Content area.
- Sidebar opsional untuk halaman dalam group yang sama.

Contoh group:

- Profil.
- Pelayanan.
- Pengaduan.
- PPID.

## PPID

PPID tidak boleh diperlakukan sebagai satu halaman panjang. Live site menunjukkan PPID punya navigasi sendiri.

Layout:

- Header PPID atau page hero sederhana.
- Sidebar/group navigation desktop.
- Accordion navigation di mobile.
- Content area kanan.

Group menu:

- Tentang PPID.
- Informasi Publik.
- Pelayanan.
- Kritik dan Saran.

Komponen:

- Document list.
- External/internal link list.
- Download button.
- Empty state untuk dokumen yang belum tersedia.
- Breadcrumb tetap aktif.

## Jadwal Penerbangan

Desktop:

- Tab Keberangkatan/Kedatangan.
- Filter maskapai dan rute.
- Tabel:
  - Maskapai.
  - Nomor penerbangan.
  - Jam.
  - Rute.
  - Hari.

Mobile:

- Card list per penerbangan.
- Jam dan rute paling menonjol.

Empty state:

- `Belum ada jadwal aktif.`

## Kontak

Layout:

- Informasi kontak kiri.
- Form kontak kanan.
- Maps di bawah.

Field form:

- Nama.
- Email.
- Nomor HP.
- Subjek.
- Pesan.

## Admin Filament

Gunakan layout bawaan Filament.

Branding cukup:

- Logo.
- Warna primary.
- Nama panel: `Admin Bandara Kalimarau`.

Jangan custom berat kecuali dibutuhkan.

# VALIDASI LIVE SITE

Tanggal validasi: 2026-07-17

## Sumber Validasi

- Live site `https://kalimarau-airport.com/`.
- Live page `https://kalimarau-airport.com/berita/`.
- Live page `https://kalimarau-airport.com/kontak/`.
- Live page `https://kalimarau-airport.com/ppid/`.
- Live post `https://kalimarau-airport.com/jadwal-penerbangan-terbaru-di-bandara-kalimarau/`.
- Backup lokal WordPress di folder ini.
- SQL dump lama yang sudah dikarantina.

## Temuan Penting

### 1. Live Site Masih Bisa Diakses Sebagian

Homepage, berita, kontak, PPID, dan beberapa post bisa dibaca dari live site.

Namun ada inkonsistensi: URL `https://kalimarau-airport.com/profil-bandara-kalimarau/` sempat mengarah ke halaman Hostinger `Your domain is expired`. Ini perlu dicek manual di browser/hosting karena bisa berarti masalah cache, DNS, SSL, atau routing Hostinger.

Keputusan migrasi:

- Jangan jadikan live site sebagai satu-satunya sumber kebenaran.
- Pakai kombinasi live site + dump lokal + review manual.

### 2. Menu Utama Terkonfirmasi

Menu utama yang tampil di live site:

- Beranda.
- Berita.
- Profil:
  - Maklumat Pelayanan.
  - Profile Bandara Kalimarau.
  - Struktur Organisasi.
  - Visi & Misi.
- Pelayanan dan Kerjasama:
  - Pengajuan Pas Bandara.
  - Fasilitas Disewakan.
  - Tarif Kebandarudaraan.
  - Standar Pelayanan.
  - Buku Tamu.
- Pengaduan:
  - Monev Kepuasan Pengguna Jasa.
  - Survey Kepuasan Masyarakat (Kemenhub).
  - Sistem Manajemen Pengaduan (SIMADU).
  - SP4N Lapor.
  - Hasil Dan Tindak Lanjut.
- PPID.
- Kontak.

Keputusan migrasi:

- Sitemap utama yang sudah dibuat valid.
- Semua item di atas tetap masuk MVP, kecuali Buku Tamu bisa ditunda jika ternyata tidak aktif.

### 3. `idpas.kalimarau-airport.com`

Live menu menampilkan `Pengajuan Pas Bandara` sebagai link ke subdomain `idpas.kalimarau-airport.com`.

Di backup lokal tidak ditemukan aplikasi/folder untuk subdomain ini.

Keputusan migrasi:

- Tetap jadikan external link.
- Jangan build ulang fitur IDPAS dalam MVP Laravel utama.
- Jika nanti backup/akses subdomain tersedia, treat sebagai proyek migrasi terpisah.

### 4. Berita Terkini Lebih Baru Dari Dump Yang Terlihat Saat Audit Awal

Live homepage dan halaman berita menampilkan post tahun 2026, seperti:

- Keberangkatan Calon Jemaah Haji Berau di Bandara Kalimarau.
- Persiapan Keberangkatan Calon Jemaah Haji Berau di Bandara Kalimarau.
- Penyambutan kedatangan Danpussenarmed TNI AD.
- Latihan Basah Unit PKP-PK 2026.
- Kegiatan Safety Awareness dan FOD Prevention Campaign.
- Pembukaan Posko Angkutan Lebaran Tahun 2026.

Keputusan migrasi:

- Data import harus memakai dump paling baru atau crawl live site sebelum freeze.
- Jangan mengandalkan daftar post dari audit awal saja.

### 5. Jadwal Penerbangan Aktual Bukan Tabel Terstruktur

Post live `jadwal-penerbangan-terbaru-di-bandara-kalimarau` hanya memuat ringkasan maskapai dan rute:

- Wings Air ke Samarinda.
- Batik Air ke Jakarta & Surabaya.
- Super Air Jet ke Balikpapan & Surabaya.
- Sriwijaya Air ke Balikpapan & Makassar.
- AirAsia ke Balikpapan & Surabaya.
- Citilink ke Balikpapan.
- Smart Aviation ke Maratua.

Tidak ada tabel jam terstruktur di konten post live tersebut.

Keputusan migrasi:

- `flight_schedules` tetap bagus sebagai desain Laravel, tetapi data awal perlu input manual/CSV dari jadwal resmi.
- Untuk MVP, kalau jadwal detail belum tersedia, tampilkan halaman "Jadwal Penerbangan" berbasis info maskapai/rute dulu, lalu siapkan admin untuk data terstruktur.
- Jangan import TablePress lama sebagai jadwal aktif.

### 6. PPID Punya Struktur Sendiri

Halaman `/ppid/` live bukan sekadar halaman biasa. Ia punya menu PPID sendiri:

- Tentang PPID:
  - Profil PPID.
  - Visi Dan Misi.
  - Tugas Dan Fungsi.
  - Struktur Organisasi.
  - Struktur Organisasi PPID Pelaksana UPT.
  - Regulasi.
- Informasi Publik:
  - Informasi Berkala.
  - Informasi Setiap Saat.
  - Informasi Serta Merta.
  - Formulir Pengajuan Informasi.
- Pelayanan:
  - Maklumat Pelayanan & Standar Biaya.
  - Prosedur Permohonan Informasi.
  - Prosedur Permohonan Keberatan Informasi.
  - Prosedur Pengajuan Sengketa Informasi Publik.
  - Laporan Layanan Informasi Publik.
  - Laporan Kepuasan Pelayanan Informasi Publik.
- Kritik dan Saran.

Keputusan migrasi:

- PPID harus jadi section/module sendiri, bukan satu halaman statis saja.
- `SITEMAP LARAVEL.md` perlu mempertahankan nested PPID routes.
- MVP minimal PPID harus punya hub page dan semua link/subpage penting.

### 7. Kontak Terkonfirmasi

Kontak live menampilkan:

- Nama/label: Blu Airport.
- Alamat: Teluk Bayur, 77315, Kab. Berau, Kalimantan Timur.
- Telepon/WhatsApp: `0852 6214 6214`.
- Social links: Facebook, Twitter, Instagram, YouTube, TikTok.
- Weblink:
  - Kementerian Perhubungan.
  - Dirjen Perhubungan Udara.
  - Airnav.
  - JDIH Kemenhub.
  - Otband VII - Balikpapan.

Keputusan migrasi:

- Nomor WhatsApp resmi untuk MVP: `0852 6214 6214`.
- Footer Laravel harus membawa alamat, nomor, social links, dan weblink.

## Koreksi Dokumen Turunan

Perlu update:

- `SITEMAP LARAVEL.md`: tambah detail nested PPID routes.
- `WIREFRAME UI.md`: PPID bukan cuma page biasa, harus punya layout hub + group menu.
- `DATA MIGRATION PLAN.md`: data berita 2026 dari live harus dicrawl/import dari sumber terbaru.
- `REDIRECT MAP.md`: tambah rute PPID nested setelah URL final ditetapkan.

## Kesimpulan

Scope migrasi tetap valid, tapi PPID dan data jadwal perlu perlakuan lebih serius:

- PPID = module/section sendiri.
- Jadwal penerbangan = jangan import mentah, input ulang sebagai data resmi.
- Berita = pastikan dump terbaru atau crawl live sebelum freeze.
- IDPAS = external app, bukan bagian dari backup ini.

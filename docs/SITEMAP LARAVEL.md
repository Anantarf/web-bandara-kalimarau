# SITEMAP LARAVEL

## Tujuan

Menentukan struktur URL final untuk versi Laravel dan memetakan halaman lama WordPress yang perlu dibawa, digabung, atau diarahkan ke external link.

## Prinsip URL

- URL pendek, stabil, dan mudah dibaca.
- Gunakan bahasa Indonesia sesuai situs lama.
- Pertahankan slug lama untuk halaman penting jika masih relevan.
- Berita lama boleh mempertahankan slug agar redirect mudah.
- External service tetap external sampai aplikasinya ikut dimigrasi.

## Navigasi Utama

### Beranda

| Label | URL Baru | Status | Catatan |
|---|---|---|---|
| Beranda | `/` | MVP | Homepage utama. |

### Berita

| Label | URL Baru | Status | Catatan |
|---|---|---|---|
| Berita | `/berita` | MVP | Listing berita. |
| Detail Berita | `/berita/{slug}` | MVP | Gunakan slug post lama jika memungkinkan. |
| Kategori Berita | `/berita/kategori/{slug}` | Setelah MVP | Bisa ditunda jika kategori tidak banyak. |
| Pencarian Berita | `/berita?search=` | MVP | Query sederhana. |

### Profil

| Label | URL Baru | URL Lama | Status | Catatan |
|---|---|---|---|---|
| Profil Bandara Kalimarau | `/profil-bandara-kalimarau` | `/profil-bandara-kalimarau/` | MVP | Halaman profil utama. |
| Maklumat Pelayanan | `/maklumat-pelayanan` | `/maklumat-pelayanan/` | MVP | Halaman statis. |
| Struktur Organisasi | `/struktur-organisasi` | `/struktur-organisasi/` | MVP | Bisa berisi gambar struktur + deskripsi. |
| Visi & Misi | `/visi-misi` | `/visi-misi/` | MVP | Halaman statis. |

### Pelayanan dan Kerjasama

| Label | URL Baru | URL Lama | Status | Catatan |
|---|---|---|---|---|
| Pengajuan Pas Bandara | external | `http://idpas.kalimarau-airport.com` | MVP | External link, app tidak ada di backup ini. |
| Fasilitas Disewakan | `/fasilitas-disewakan` | `/fasilitas-disewakan/` | MVP | Halaman statis atau layanan. |
| Tarif Kebandarudaraan | `/tarif-kebandarudaraan` | `/tarif-kebandarudaraan-2/` | MVP | Slug baru lebih bersih, redirect dari slug lama. |
| Standar Pelayanan | `/standar-pelayanan` | `/standar-pelayanan/` | MVP | Halaman statis/dokumen. |
| Buku Tamu | `/buku-tamu` | `/buku-tamu/` | Setelah MVP | Bisa external/form internal, perlu verifikasi. |

### Pengaduan

| Label | URL Baru | URL Lama | Status | Catatan |
|---|---|---|---|---|
| Monev Kepuasan Pengguna Jasa | `/survey-kepuasan-masyarakat-internal` | `/survey-kepuasan-masyarakat-internal/` | MVP | Bisa halaman pengantar + external/form. |
| Survey Kepuasan Kemenhub | `/survey-kepuasan-eksternal-kemenhub` | `/survey-kepuasan-eksternal-kemenhub/` | MVP | Perlu cek link tujuan. |
| SIMADU | `/simadu` | `/simadu/` | MVP | Bisa external link. |
| SP4N Lapor | `/sp4n-lapor` | `/sp4n-lapor/` | MVP | External link. |
| Hasil dan Tindak Lanjut | `/hasil-dan-tindak-lanjut` | `/hasil-dan-tindak-lanjut/` | MVP | Halaman statis/list dokumen. |

### PPID

| Label | URL Baru | URL Lama | Status | Catatan |
|---|---|---|---|---|
| PPID | `/ppid` | `/ppid/` | MVP | Halaman hub PPID. |
| Profil PPID | `/ppid/profil` | perlu mapping | MVP | Submenu Tentang PPID. |
| Visi dan Misi PPID | `/ppid/visi-misi` | perlu mapping | MVP | Submenu Tentang PPID. |
| Tugas dan Fungsi PPID | `/ppid/tugas-dan-fungsi` | perlu mapping | MVP | Submenu Tentang PPID. |
| Struktur Organisasi PPID | `/ppid/struktur-organisasi` | perlu mapping | MVP | Jangan pertahankan slug lama yang terlalu pendek jika ada. |
| Struktur Organisasi PPID Pelaksana UPT | `/ppid/struktur-organisasi-pelaksana-upt` | perlu mapping | MVP | Submenu Tentang PPID. |
| Regulasi PPID | `/ppid/regulasi` | perlu mapping | MVP | Bisa listing dokumen. |
| Informasi Berkala | `/ppid/informasi-berkala` | perlu mapping | MVP | Informasi publik. |
| Informasi Setiap Saat | `/ppid/informasi-setiap-saat` | perlu mapping | MVP | Informasi publik. |
| Informasi Serta Merta | `/ppid/informasi-serta-merta` | perlu mapping | MVP | Informasi publik. |
| Formulir Pengajuan Informasi | `/ppid/formulir-pengajuan-informasi` | perlu mapping | MVP | Bisa file/link/form. |
| Maklumat Pelayanan & Standar Biaya | `/ppid/maklumat-pelayanan-standar-biaya` | perlu mapping | MVP | Pelayanan PPID. |
| Prosedur Permohonan Informasi | `/ppid/prosedur-permohonan-informasi` | perlu mapping | MVP | Pelayanan PPID. |
| Prosedur Permohonan Keberatan Informasi | `/ppid/prosedur-keberatan-informasi` | perlu mapping | MVP | Pelayanan PPID. |
| Prosedur Sengketa Informasi Publik | `/ppid/prosedur-sengketa-informasi-publik` | perlu mapping | MVP | Pelayanan PPID. |
| Laporan Layanan Informasi Publik | `/ppid/laporan-layanan-informasi-publik` | perlu mapping | Setelah MVP | Jika dokumen tersedia. |
| Laporan Kepuasan Pelayanan Informasi Publik | `/ppid/laporan-kepuasan-pelayanan-informasi-publik` | perlu mapping | Setelah MVP | Jika dokumen tersedia. |
| Kritik dan Saran PPID | `/ppid/kritik-saran` | perlu mapping | MVP | Bisa form/link. |

### Kontak

| Label | URL Baru | URL Lama | Status | Catatan |
|---|---|---|---|---|
| Kontak | `/kontak` | `/kontak/` | MVP | Alamat, peta, email, telepon, form. |

## Halaman Sistem

| Label | URL Baru | Status | Catatan |
|---|---|---|---|
| Login Admin | `/admin/login` | MVP | Filament. |
| Admin Panel | `/admin` | MVP | Filament dashboard. |
| Search | `/search?q=` | MVP | Search halaman + berita. |
| Sitemap XML | `/sitemap.xml` | MVP | Generate dari data. |
| Robots | `/robots.txt` | MVP | File statis/dinamis. |
| 404 | fallback | MVP | Halaman error custom. |

## Prioritas Build

1. `/`
2. `/berita`
3. `/berita/{slug}`
4. halaman Profil
5. halaman Pelayanan
6. halaman Pengaduan
7. `/ppid`
8. `/kontak`
9. `/admin`
10. redirect URL lama

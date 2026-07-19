# REDIRECT MAP

## Tujuan

Menjaga URL lama WordPress tetap bekerja setelah migrasi ke Laravel.

## Aturan Umum

- Gunakan 301 untuk redirect permanen.
- Pertahankan slug lama untuk berita jika memungkinkan.
- Redirect halaman yang slug-nya berubah ke URL baru yang lebih bersih.
- External link tidak perlu redirect internal, cukup tampil sebagai link.
- Normalisasi trailing slash: `/path/` diarahkan ke `/path` jika route Laravel memakai format tanpa slash.
- Query string hanya dipertahankan jika masih relevan untuk halaman baru.
- Redirect tidak boleh loop dan tidak boleh menimpa route Laravel yang valid.
- `old_path` harus unique.

## Redirect Halaman Utama

| URL Lama | URL Baru | Status |
|---|---|---|
| `/` | `/` | keep |
| `/berita/` | `/berita` | 301 |
| `/profil-bandara-kalimarau/` | `/profil-bandara-kalimarau` | 301 |
| `/maklumat-pelayanan/` | `/maklumat-pelayanan` | 301 |
| `/struktur-organisasi/` | `/struktur-organisasi` | 301 |
| `/visi-misi/` | `/visi-misi` | 301 |
| `/fasilitas-disewakan/` | `/fasilitas-disewakan` | 301 |
| `/tarif-kebandarudaraan-2/` | `/tarif-kebandarudaraan` | 301 |
| `/standar-pelayanan/` | `/standar-pelayanan` | 301 |
| `/buku-tamu/` | `/buku-tamu` | 301 |
| `/survey-kepuasan-masyarakat-internal/` | `/survey-kepuasan-masyarakat-internal` | 301 |
| `/survey-kepuasan-eksternal-kemenhub/` | `/survey-kepuasan-eksternal-kemenhub` | 301 |
| `/simadu/` | `/simadu` | 301 |
| `/sp4n-lapor/` | `/sp4n-lapor` | 301 |
| `/hasil-dan-tindak-lanjut/` | `/hasil-dan-tindak-lanjut` | 301 |
| `/ppid/` | `/ppid` | 301 |
| `/kontak/` | `/kontak` | 301 |

## External Links

| Label | URL | Status |
|---|---|---|
| Pengajuan Pas Bandara | `http://idpas.kalimarau-airport.com` | external |

## Redirect PPID

URL lama detail PPID perlu diekstrak dari database/menu lama sebelum final. URL baru yang disarankan:

| URL Lama | URL Baru | Status |
|---|---|---|
| perlu mapping | `/ppid/profil` | pending |
| perlu mapping | `/ppid/visi-misi` | pending |
| perlu mapping | `/ppid/tugas-dan-fungsi` | pending |
| perlu mapping | `/ppid/struktur-organisasi` | pending |
| perlu mapping | `/ppid/struktur-organisasi-pelaksana-upt` | pending |
| perlu mapping | `/ppid/regulasi` | pending |
| perlu mapping | `/ppid/informasi-berkala` | pending |
| perlu mapping | `/ppid/informasi-setiap-saat` | pending |
| perlu mapping | `/ppid/informasi-serta-merta` | pending |
| perlu mapping | `/ppid/formulir-pengajuan-informasi` | pending |
| perlu mapping | `/ppid/maklumat-pelayanan-standar-biaya` | pending |
| perlu mapping | `/ppid/prosedur-permohonan-informasi` | pending |
| perlu mapping | `/ppid/prosedur-keberatan-informasi` | pending |
| perlu mapping | `/ppid/prosedur-sengketa-informasi-publik` | pending |
| perlu mapping | `/ppid/kritik-saran` | pending |

Sebelum launch, semua baris PPID di atas harus berubah dari `pending` menjadi URL lama yang eksplisit atau diberi keputusan `drop` jika halaman lama tidak valid. Slug pendek `/s/` harus diarahkan ke `/ppid/struktur-organisasi` jika kontennya tetap dipakai.

## Redirect Berita

Strategi:

- Jika slug lama masih valid, route Laravel harus menerima `/slug-lama` atau redirect ke `/berita/slug-lama`.
- Lebih rapi: semua berita baru di `/berita/{slug}`, lalu URL lama root post diarahkan ke sana.

Format:

| URL Lama | URL Baru | Status |
|---|---|---|
| `/jadwal-penerbangan-terbaru-di-bandara-kalimarau/` | `/berita/jadwal-penerbangan-terbaru-di-bandara-kalimarau` | pending |
| `/diskon-tarif-harga-tiket-pesawat-13-14-untuk-periode-nataru-2025-2026/` | `/berita/diskon-tarif-harga-tiket-pesawat-13-14-untuk-periode-nataru-2025-2026` | pending |
| `/sosialisasi-alat-pemadam-api-ringan-apar-dan-fire-blanket/` | `/berita/sosialisasi-alat-pemadam-api-ringan-apar-dan-fire-blanket` | pending |
| `/inaugurasi-penerbangan-perdana-air-asia-di-bandara-kalimarau-berau/` | `/berita/inaugurasi-penerbangan-perdana-air-asia-di-bandara-kalimarau-berau` | pending |

## Implementasi Laravel

- Buat tabel `redirects`.
- Kolom:
  - `old_path`.
  - `new_path`.
  - `status_code`.
- Middleware cek request path sebelum 404.
- Cache redirect map untuk performance.
- Test minimal:
  - halaman utama lama menghasilkan 301.
  - slug berita lama menghasilkan 301 ke `/berita/{slug}`.
  - PPID lama menghasilkan 301 ke route PPID baru.
  - URL yang tidak ada tetap 404, bukan diarahkan asal ke homepage.
  - redirect tidak loop.

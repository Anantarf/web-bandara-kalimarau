# Plan: Retouch Navigasi & Beranda (mengikuti pola aptpairport.id)

**Status:** Draft — menunggu review
**Konteks:** Setelah membandingkan struktur navigasi & section beranda proyek ini dengan https://aptpairport.id/, ditemukan gap di pengelompokan submenu dan beberapa section beranda yang belum ada. Plan ini merapikan keduanya — **mengikuti pola fitur & layout**, bukan meniru visual/warna/font persis. Branding (navy/gold/sky, font Plus Jakarta Sans / serif judul) tetap dipakai apa adanya.

Tidak ada perubahan pada backend jadwal penerbangan, berita, PPID, kontak, atau sistem lain di luar navigasi header dan halaman beranda.

---

## Bagian 1 — Navigasi Header

### Struktur baru

| Menu | Isi | Sumber |
|---|---|---|
| Beranda | link tunggal | sudah ada |
| **Informasi Publik** *(rename dari "Profil")* | Profil Bandara, Struktur Organisasi, Visi & Misi, Maklumat Pelayanan | sudah ada, cuma dikelompok ulang labelnya |
| **Layanan** *(rename dari "Pelayanan")* | Fasilitas Disewakan, Tarif Kebandarudaraan, Standar Pelayanan, Pengajuan Pas Bandara (eksternal) | sudah ada |
| **PPID** *(diubah dari link tunggal jadi dropdown)* | 16 halaman PPID yang sudah ter-import (Profile PPID, Regulasi, Struktur Organisasi PPID, Tugas & Fungsi, Informasi Berkala/Serta Merta/Setiap Saat, dst — daftar lengkap di bawah) | sudah ada di tabel `pages` (template=`ppid`) |
| **Informasi** *(dropdown baru)* | Berita | sudah ada |
| Pengaduan | Survey Kepuasan, SIMADU, SP4N Lapor, Hasil & Tindak Lanjut | sudah ada, tidak berubah |
| Kontak | link tunggal | sudah ada |

**Isi dropdown PPID** (title → route):
```
Profile PPID, PPID, Regulasi, Struktur Organisasi, Struktur Organisasi PPID Pelaksana UPT,
Tugas Dan Fungsi, Visi Misi PPID, Informasi Berkala, Informasi Serta Merta, Informasi Setiap Saat,
Formulir Pengajuan Informasi, Kritik & Saran, Maklumat Pelayanan dan Standar Biaya,
Prosedur Pengajuan Sengketa Informasi Publik, Prosedur Permohonan Informasi,
Prosedur Permohonan Keberatan Informasi
```
16 item terlalu banyak untuk 1 dropdown flat — akan dikelompokkan jadi 2 level (mengikuti pola referensi yang punya nested submenu "Layanan Informasi"):
- **Profil PPID**: Profile PPID, PPID, Struktur Organisasi PPID, Tugas Dan Fungsi, Visi Misi PPID
- **Layanan Informasi** *(nested)*: Informasi Berkala, Informasi Serta Merta, Informasi Setiap Saat, Formulir Pengajuan Informasi
- **Regulasi & Prosedur**: Regulasi, Prosedur Permohonan Informasi, Prosedur Permohonan Keberatan Informasi, Prosedur Pengajuan Sengketa Informasi Publik, Maklumat Pelayanan dan Standar Biaya, Kritik & Saran

### Tidak dikerjakan (butuh konten baru dulu, di luar scope "navigasi")
Referensi punya menu **Regulasi** (Surat Keputusan, Surat Edaran) dan sub-item **Kinerja Keuangan**, **Pejabat Bandara** — proyek ini belum punya halaman/data untuk itu. Menambah entri navigasi ke halaman yang belum ada cuma bikin link 404. **Diskip** sampai kontennya dibuat oleh tim editorial (bisa lewat halaman baru di `PageResource` yang sudah ada).

---

## Bagian 2 — Section Beranda

### Urutan baru

| # | Section | Status |
|---|---|---|
| 1 | Hero carousel | tetap, tidak berubah |
| 2 | Quick Links | tetap, tidak berubah |
| 3 | **Sambutan Kepala Bandara** | 🆕 baru |
| 4 | **Aktivitas Bandara** (statistik) | 🆕 baru |
| 5 | Jadwal Penerbangan | tetap |
| 6 | **Jelajahi Bandara**: Fasilitas + **Wisata Terdekat** | diperluas (Fasilitas sudah ada, Wisata baru) |
| 7 | **Mitra Terkemuka** | 🆕 baru |
| 8 | Berita Terkini | tetap |
| 9 | Layanan Publik | tetap (referensi taruh ini di menu, bukan section — tapi dipertahankan karena sudah berfungsi baik) |
| — | ~~Unit Kerja~~ | **dipindah keluar dari beranda** ke halaman Struktur Organisasi (`/ppid/struktur-organisasi`) — referensi tidak menaruh info unit kerja internal di beranda |

### Detail per section baru + keputusan sumber data

**Sambutan Kepala Bandara**
Blok foto + kutipan sambutan, 1 data point saja (tidak berubah-ubah tiap bulan). Mengikuti pola yang sudah ada di `HomeController` (`HERO_IMAGES`, `FACILITIES` — konstanta PHP, bukan tabel DB, karena kontennya jarang berubah dan tidak butuh CRUD admin). **Keputusan: konstanta PHP di `HomeController`, bukan tabel baru.**

**Aktivitas Bandara (statistik bulanan)**
Ini beda dari section lain — datanya *memang berubah tiap bulan* (jumlah penumpang, pergerakan pesawat, dll), dan **tidak ada tabel yang menyimpan angka ini sekarang** (`flight_schedules` cuma simpan jadwal, bukan data realisasi/jumlah penumpang). Ada 2 opsi:
- **(A) Tabel baru `airport_stats`** (bulan, jumlah_penumpang, jumlah_pergerakan_pesawat, dst) + Filament Resource sederhana untuk admin input manual tiap bulan. Effort: migration + model + 1 resource kecil (~1-2 jam kerja).
- **(B) Konstanta PHP sementara** (angka hardcode), diupgrade ke (A) nanti kalau sudah butuh update rutin.
**Rekomendasi: (A)** — ini satu-satunya section baru yang datanya genuinely berubah rutin per bulan, jadi masuk akal punya tempat input sendiri di admin panel (bukan edit kode tiap bulan).

**Wisata Terdekat**
Sama seperti Fasilitas yang sudah ada — daftar tempat (nama, deskripsi, foto), jarang berubah. **Keputusan: konstanta PHP**, pola identik dengan `FACILITIES` yang sudah ada, ditaruh berdampingan di section "Jelajahi Bandara".

**Mitra Terkemuka**
Grid logo maskapai/instansi + link. Kemungkinan berubah kalau ada maskapai baru masuk/keluar rute, tapi frekuensinya rendah (bukan bulanan). **Keputusan: konstanta PHP** dulu (pola sama seperti Fasilitas/Wisata) — kalau ke depan sering ganti-ganti, gampang diupgrade ke tabel `partners` + Filament Resource (pola sama seperti `PublicServiceLinkResource` yang sudah dibuat).

### Di luar scope plan ini
- **Widget cuaca BMKG** — integrasi API pihak ketiga terpisah, dibahas sebagai sub-project sendiri kalau diperlukan.
- **Panel aksesibilitas** — fitur JS site-wide terpisah, sub-project sendiri.
- **"Terhubung ke Seluruh Nusantara"** (deskripsi rute) — teks statis kecil, bisa ditambah cepat saat implementasi bagian ini sebagai bonus (tidak butuh keputusan data terpisah).

---

## Urutan eksekusi (2 sub-project)

1. **Navigasi header** — restrukturisasi dropdown, termasuk PPID nested submenu. Tidak ada perubahan database.
2. **Section beranda** — tambah `airport_stats` (migration + model + Filament Resource), tambah konstanta Wisata & Mitra, tambah blok Sambutan, pindahkan Unit Kerja keluar dari beranda, susun ulang urutan section.

Masing-masing dieksekusi terpisah supaya gampang di-review dan di-test satu-satu.

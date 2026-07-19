# DATA RESOLUTION STATUS

Tanggal: 2026-07-17

## Tujuan

Mengunci status data yang sebelumnya dianggap belum final: jadwal penerbangan detail, dokumen PPID, email/form kontak, dan akses/subdomain IDPAS.

## Status Ringkas

| Area | Status | Keputusan |
|---|---|---|
| Jadwal penerbangan detail | Blocked by source | Tidak ada data jam detail di live site/dump yang bisa dipercaya. MVP tetap sediakan modul `flight_schedules`, tapi data awal harus input manual dari jadwal resmi. |
| PPID | Resolved for sitemap | Struktur menu PPID sudah terkunci dari live site. Dokumen/file detail tetap perlu inventaris saat import media. |
| Kontak/WhatsApp | Resolved public contact | Nomor publik resmi dari live site: `0852 6214 6214`. Email tujuan form belum muncul di halaman kontak, gunakan config admin/env saat build. |
| IDPAS | Resolved as external | Tidak ada source app di backup ini. Treat sebagai external link `idpas.kalimarau-airport.com`, bukan bagian MVP Laravel utama. |

## Jadwal Penerbangan

### Temuan

Live post `jadwal-penerbangan-terbaru-di-bandara-kalimarau` hanya mencantumkan maskapai dan rute:

- Wings Air -> Samarinda.
- Batik Air -> Jakarta & Surabaya.
- Super Air Jet -> Balikpapan & Surabaya.
- Sriwijaya Air -> Balikpapan & Makassar.
- AirAsia -> Balikpapan & Surabaya.
- Citilink -> Balikpapan.
- Smart Aviation -> Maratua.

Tidak ada jam, hari operasi, nomor penerbangan detail, atau status aktif per jadwal.

### Keputusan

- Jangan membuat data palsu.
- Buat modul `flight_schedules` di Laravel.
- Seed awal boleh kosong atau hanya berisi data rute/maskapai sebagai informasi umum.
- Admin harus bisa input jadwal detail saat data resmi tersedia.
- Frontend harus punya empty state yang jelas: `Jadwal detail belum tersedia. Silakan cek informasi terbaru atau hubungi kontak bandara.`

### Yang Dibutuhkan Dari Pihak Resmi

- Maskapai.
- Nomor penerbangan.
- Rute.
- Jam keberangkatan/kedatangan.
- Hari operasi.
- Periode berlaku.
- Catatan perubahan jadwal.

## PPID

### Temuan

PPID live punya struktur sendiri:

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

### Keputusan

- PPID masuk MVP sebagai section/module sendiri.
- Sitemap PPID sudah cukup untuk build awal.
- Dokumen final per halaman PPID tetap harus diinventaris saat import media.

### Yang Masih Perlu Dicek Saat Import

- File regulasi.
- File formulir.
- File laporan layanan.
- File laporan kepuasan.
- Apakah ada dokumen yang sudah kedaluwarsa.

## Kontak dan Email Form

### Temuan

Live kontak menampilkan:

- Alamat: Teluk Bayur, 77315, Kab. Berau, Kalimantan Timur.
- Telepon/WhatsApp: `0852 6214 6214`.
- Weblink footer:
  - Kementerian Perhubungan.
  - Dirjen Perhubungan Udara.
  - Airnav.
  - JDIH Kemenhub.
  - Otband VII - Balikpapan.

Email publik tidak terlihat di halaman kontak live.

### Keputusan

- Gunakan `0852 6214 6214` sebagai WhatsApp CTA publik.
- Email tujuan form jangan ditebak.
- Laravel harus memakai setting/env:
  - `CONTACT_RECIPIENT_EMAIL`
  - bisa diubah dari admin settings setelah MVP.
- Jika email belum diisi, form tetap simpan pesan di admin dan tidak mengirim email.

## IDPAS

### Temuan

- `Pengajuan Pas Bandara` di menu mengarah ke `idpas.kalimarau-airport.com`.
- Tidak ada folder/app IDPAS di backup lokal.
- Tidak ditemukan source IDPAS di zip yang dicek.

### Keputusan

- Treat sebagai external link.
- Tidak masuk scope rebuild Laravel utama.
- Tambahkan status health/manual note di admin link service.

### Jika Nanti Mau Dimigrasi

IDPAS harus jadi proyek terpisah dengan audit sendiri:

- source code.
- database.
- auth/user.
- alur pengajuan pas.
- dokumen upload.
- approval workflow.
- keamanan data pemohon.

## Dampak Ke Build Laravel

- Tidak ada blocker untuk mulai build MVP.
- Blocker jadwal detail tidak menghentikan build karena modul dan admin input bisa dibuat dulu.
- Email form tidak menghentikan build karena pesan bisa disimpan di database tanpa email notification.
- IDPAS tidak menghentikan build karena sudah diputuskan external.

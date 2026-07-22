# Dokumentasi Proyek Kalimarau Laravel

Status terakhir: 2026-07-22

Proyek ini adalah migrasi website Bandara Kalimarau dari WordPress/Elementor ke Laravel 11 + Filament. Dokumentasi di folder ini dipakai sebagai sumber keputusan teknis, mapping konten, backlog sprint, dan checklist QA.

## Status Sprint

| Sprint | Area | Status | Catatan |
| --- | --- | --- | --- |
| Sprint 0 | Persiapan Laravel | Selesai | Laravel, env lokal, database, Filament, Vite, dan layout dasar sudah tersedia. |
| Sprint 1 | Core Data | Selesai | Migration utama, relasi, unique slug, status konten, role/permission, dan seeder admin sudah tersedia. |
| Sprint 2 | Admin Panel | Selesai | Resource Filament untuk konten, media, jadwal, link layanan, pesan kontak, redirect, user, role, dashboard widget, **dan Facility (fasilitas bandara)** sudah tersedia. |
| Sprint 3 | Frontend Public | Selesai untuk MVP | Homepage, berita, halaman statis, PPID, jadwal, kontak, search, 404, validasi input, rate limit, breadcrumb terpusat (`<x-breadcrumb>`), dan halaman Fasilitas data-driven sudah ada. |
| Sprint 4 | Import Konten | Selesai secara teknis | Import posts/pages/media/redirect sudah berjalan. Tabel `posts` di database lokal saat ini sengaja dikosongkan (data uji sudah dibersihkan), bukan indikasi import gagal. |
| Sprint 5 | SEO dan Redirect | Selesai | Redirect table, fallback, sitemap XML, canonical, dan Open Graph sudah tervalidasi (`SeoAndRedirectTest`). |
| Sprint 5.5 | Security dan Hardening | Kode selesai, config deploy pending | CSRF, rate limit, validasi upload, header keamanan + CSP, backup otomatis terjadwal (`spatie/laravel-backup`), dan error tracking (`sentry/sentry-laravel`, inert sampai DSN diisi) sudah diimplementasikan. Sisa: nilai `.env` production aktual, permission server, cron `schedule:run` — lihat `GO-LIVE.md`. |
| Sprint 5.6 | Automated Test Minimal | Selesai | 33 test lulus, mencakup smoke test semua halaman publik, form kontak (submit valid/invalid/rate limit), redirect, scope published, scope jadwal aktif, dan admin panel. |
| Sprint 6 | QA dan Launch | Belum mulai | Menunggu keputusan deploy production; checklist lengkap ada di `GO-LIVE.md`. |

## Snapshot Data Lokal

Hasil cek lokal 2026-07-22 (`php artisan tinker`):

| Data | Jumlah |
| --- | ---: |
| Posts | 0 |
| Published posts | 0 |
| Pages | 31 |
| Media | 69 |
| Redirects | 154 |
| Flight schedules | 13 |
| Public service links | 0 |
| Facilities | 22 |
| PPID documents | 0 |

Catatan: posts sengaja dikosongkan (bukan hasil import yang hilang/gagal) — snapshot 2026-07-18 sebelumnya (164 posts / 154 published) adalah data uji import yang sudah dibersihkan.

## Dokumen Utama

- `BACKLOG LARAVEL MVP.md` - checklist sprint dan status pekerjaan.
- `GO-LIVE.md` - checklist keamanan dan runbook deploy production (env, permission server, backup, verifikasi pasca-deploy).
- `MIGRASI to LARAVEL.md` - rencana migrasi penuh dan acceptance criteria.
- `DATA MIGRATION PLAN.md` - aturan pemilahan data WordPress, import media, dan pembersihan shortcode.
- `DATA RESOLUTION STATUS.md` - keputusan data yang resolved/blocked.
- `SITEMAP LARAVEL.md` - sitemap target dan mapping URL baru.
- `REDIRECT MAP.md` - aturan redirect lama ke URL Laravel.
- `VALIDASI LIVE SITE.md` - hasil validasi live site dan catatan sumber data.
- `WIREFRAME UI.md` - arah UI public site.
- `IMPROVEMENT LOGIC LARAVEL.md` - perbaikan logic dari struktur WordPress lama.
- `superpowers/plans/2026-07-22-frontend-qa-uplift.md` - rencana & hasil uplift kualitas frontend (konsistensi visual, performa, aksesibilitas, reuse komponen).

## Fitur Utama Saat Ini

- **Konten**: Post (berita), Page (halaman statis + PPID nested routing), Category, Media, Redirect — semua CRUD lewat Filament.
- **Facility (Fasilitas Bandara)**: data-driven lewat model `Facility` + admin CRUD (`FacilityResource`), dipakai di homepage dan halaman `/fasilitas-bandara`. Gambar disimpan di `storage/app/public/facilities` (di-force-add ke git karena default `storage/.gitignore` mengecualikannya — lihat commit terkait).
- **Jadwal Penerbangan**: scope `active()`, ditampilkan publik hanya yang aktif.
- **Kontak**: form dengan validasi server-side, rate limit 3x/menit, tersimpan ke `contact_messages`.
- **Pencarian**: lintas Post/Page/PpidDocument dengan rate limit.
- **Visitor tracking**: middleware `TrackVisitor` mencatat hit harian per-IP ke tabel `visitors`, ditampilkan sebagai counter di footer.
- **Breadcrumb terpusat**: komponen `<x-breadcrumb>` dipakai di semua halaman publik kecuali `faq.blade.php` yang sudah dimigrasikan juga.
- **Preview konten**: signed URL 30 menit untuk draft post/page, `noindex` otomatis.
- **Audit log**: perubahan admin (kecuali data sensitif) tercatat lewat `AuditLogObserver`.

## Validasi Terakhir

Command yang terakhir lulus (2026-07-22):

```bash
vendor/bin/pint --test
php artisan test          # 33 passed (110 assertions)
npm run build
```

## Catatan Risiko

- Konten hasil import masih perlu editorial QA karena sebagian halaman lama berasal dari Elementor/shortcode.
- `storage/app/public/media/legacy` berisi asset migrasi dan cukup besar; sengaja tidak di-git (lihat `storage/app/public/.gitignore`) — pastikan ada strategi backup/replikasi terpisah untuk folder ini di server production.
- **Upload (Facility, PPID Document, Media, featured image) 100% disk lokal server**, belum ada disk cloud (S3 dkk) yang benar-benar dipakai — risiko kehilangan file kalau server di-redeploy/di-scale ke banyak instance. Mitigasi saat ini: backup otomatis harian (`spatie/laravel-backup`) + backup manual pre-deploy (`GO-LIVE.md`).
- Folder generated/local seperti `vendor`, `node_modules`, `public/build`, `.env`, `graphify-out`, serta folder dump foto mentah (`PPID/`, `fasilitas/`, `logo maskapai/`, `output/`, `*.DNG`) harus tetap diabaikan Git — sudah dikonfigurasi di `.gitignore`.
- Belum ada CI/CD; `php artisan test` masih dijalankan manual sebelum deploy.
- Filament (v3) dan Laravel (v11) beberapa versi mayor di belakang rilis terbaru — bukan penghalang launch, tapi rencanakan jadwal upgrade.
- Sebelum launch, wajib tutup Sprint 6 dan jalankan seluruh checklist `GO-LIVE.md`.

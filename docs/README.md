# Dokumentasi Proyek Kalimarau Laravel

Status terakhir: 2026-07-18

Proyek ini adalah migrasi website Bandara Kalimarau dari WordPress/Elementor ke Laravel 11 + Filament. Dokumentasi di folder ini dipakai sebagai sumber keputusan teknis, mapping konten, backlog sprint, dan checklist QA.

## Status Sprint

| Sprint | Area | Status | Catatan |
| --- | --- | --- | --- |
| Sprint 0 | Persiapan Laravel | Selesai | Laravel, env lokal, database, Filament, Vite, dan layout dasar sudah tersedia. |
| Sprint 1 | Core Data | Selesai | Migration utama, relasi, unique slug, status konten, role/permission, dan seeder admin sudah tersedia. |
| Sprint 2 | Admin Panel | Selesai | Resource Filament untuk konten, media, jadwal, link layanan, pesan kontak, redirect, user, role, policy, dan dashboard widget sudah tersedia. |
| Sprint 3 | Frontend Public | Selesai untuk MVP | Homepage, berita, halaman statis, PPID, jadwal, kontak, search, 404, validasi input, dan rate limit sudah ada. |
| Sprint 4 | Import Konten | Selesai secara teknis | Import posts/pages/media/redirect sudah berjalan. Masih perlu review editorial manual untuk konten hasil import dan asset PPID. |
| Sprint 5 | SEO dan Redirect | Berjalan | Redirect table dan fallback sudah ada. Sitemap XML, canonical, Open Graph, dan final QA redirect masih perlu ditutup. |
| Sprint 5.5 | Security dan Hardening | Belum final | Perlu review production env, upload policy, deployment cache, backup, dan folder permission. |
| Sprint 5.6 | Automated Test Minimal | Berjalan | Smoke test admin dan test dasar lulus. Coverage route publik dan redirect masih perlu ditambah. |
| Sprint 6 | QA dan Launch | Belum mulai | Menunggu SEO, hardening, test coverage, staging, dan final content review. |

## Snapshot Data Lokal

Hasil cek lokal 2026-07-18:

| Data | Jumlah |
| --- | ---: |
| Posts | 164 |
| Published posts | 154 |
| Pages | 30 |
| Media | 69 |
| Redirects | 156 |
| Flight schedules | 0 |
| Public service links | 0 |

Catatan: jadwal penerbangan dan public service links belum punya seed/data aktif. Jangan import TablePress lama sebagai jadwal resmi karena sumber lama sudah dinilai tidak valid.

## Dokumen Utama

- `BACKLOG LARAVEL MVP.md` - checklist sprint dan status pekerjaan.
- `MIGRASI to LARAVEL.md` - rencana migrasi penuh dan acceptance criteria.
- `DATA MIGRATION PLAN.md` - aturan pemilahan data WordPress, import media, dan pembersihan shortcode.
- `DATA RESOLUTION STATUS.md` - keputusan data yang resolved/blocked.
- `SITEMAP LARAVEL.md` - sitemap target dan mapping URL baru.
- `REDIRECT MAP.md` - aturan redirect lama ke URL Laravel.
- `VALIDASI LIVE SITE.md` - hasil validasi live site dan catatan sumber data.
- `WIREFRAME UI.md` - arah UI public site.
- `IMPROVEMENT LOGIC LARAVEL.md` - perbaikan logic dari struktur WordPress lama.

## Validasi Terakhir

Command yang terakhir lulus:

```bash
vendor/bin/pint --test
php artisan test
npm run build
composer validate --strict
```

## Catatan Risiko

- Konten hasil import masih perlu editorial QA karena sebagian halaman lama berasal dari Elementor/shortcode.
- `storage/app/public/media/legacy` berisi asset migrasi dan cukup besar; jangan commit/deploy sembarangan tanpa policy asset yang jelas.
- Folder generated/local seperti `vendor`, `node_modules`, `public/build`, `.env`, dan `graphify-out` harus tetap diabaikan Git.
- Sebelum launch, wajib tutup Sprint 5, 5.5, 5.6, lalu lakukan QA Sprint 6.

# Dokumentasi Proyek — Bandara Kalimarau (Laravel)

Status: **live-ready, siap disiapkan untuk go-live.** Migrasi dari WordPress ke Laravel 11 + Filament 3 sudah selesai secara teknis; proyek sekarang dalam tahap hardening produksi dan polish.

## Mulai dari sini

| Kalau Anda mau... | Baca |
|---|---|
| Tahu apa yang sudah selesai & apa yang tersisa | `BACKLOG LARAVEL MVP.md` |
| Deploy ke server/hosting | `GO-LIVE.md` — checklist cepat di paling atas, detail teknis di bawahnya |
| Tahu cara pakai panel admin (role, alur publish, dll) | `ALUR ADMIN.md` |
| Tahu sejarah/alasan keputusan migrasi (arsip) | folder `archive/` |

## Ringkasan Fitur

- **Konten**: Post (berita), Page (halaman statis + PPID nested routing), Category, Media, Redirect — CRUD lewat Filament.
- **Facility (Fasilitas Bandara)**: data-driven lewat model `Facility` + admin CRUD, dipakai di homepage dan `/fasilitas-bandara`. Gambar disimpan di `storage/app/public/facilities` (di-*force-add* ke git karena default `.gitignore` Laravel mengecualikan `storage/app/public/*`).
- **Jadwal Penerbangan**: scope `active()`, publik cuma lihat yang aktif.
- **Kontak**: form dengan validasi server-side, rate limit 3x/menit, tersimpan ke `contact_messages`.
- **Pencarian**: lintas Post/Page/PpidDocument, `noindex` (bukan halaman untuk di-index Google), rate limit.
- **Visitor tracking**: middleware `TrackVisitor` mencatat hit harian per-IP, ditampilkan sebagai counter di footer.
- **Breadcrumb terpusat**: komponen `<x-breadcrumb>` + schema `BreadcrumbList` (JSON-LD) otomatis di semua halaman publik.
- **SEO**: canonical per-halaman (termasuk pagination), meta OG/Twitter, sitemap XML, JSON-LD (`GovernmentOrganization`, `Article`, `FAQPage`, `BreadcrumbList`), redirect 301 dari URL WordPress lama.
- **Preview konten**: signed URL 30 menit untuk draft post/page, `noindex` otomatis.
- **Audit log**: perubahan admin (kecuali data sensitif) tercatat lewat `AuditLogObserver`.
- **Backup otomatis**: `spatie/laravel-backup`, terjadwal harian (butuh cron `schedule:run` di server — lihat `GO-LIVE.md`).
- **Error tracking**: `sentry/sentry-laravel` terpasang, aktif setelah `SENTRY_LARAVEL_DSN` diisi di server.
- **CI**: GitHub Actions (`.github/workflows/ci.yml`) menjalankan test + style check di tiap push/PR ke `main`.

## Struktur Dokumen

- **`BACKLOG LARAVEL MVP.md`** — daftar hidup, dicentang seiring progres. Termasuk bagian "Disetujui tapi belum dikerjakan" untuk fitur yang sudah dispek tapi belum dibangun.
- **`GO-LIVE.md`** — checklist keamanan & runbook deploy production (env, permission server, backup, verifikasi pasca-deploy).
- **`archive/`** — dokumen perencanaan dari fase migrasi WordPress→Laravel (sitemap mapping, redirect map, wireframe, data migration plan, dll). Historis, tidak perlu dibaca untuk kerja sehari-hari, disimpan sebagai referensi kalau ada pertanyaan "kenapa strukturnya begini".

## Perintah Verifikasi

```bash
vendor/bin/pint --test
php artisan test          # 36 test, semua harus lolos
npm run build
```

Untuk kompres ulang gambar besar (foto baru yang diunggah admin di luar Filament, misalnya lewat FTP/cPanel langsung):

```bash
npm run optimize:images
```

## Catatan Penting

- **Upload (Facility, PPID Document, Media, featured image) 100% disk lokal server** — belum ada disk cloud (S3 dkk) yang benar-benar dipakai. Aman untuk 1 server, berisiko kalau nanti scale ke banyak instance/container. Mitigasi saat ini: backup otomatis harian.
- **Tidak ada CI/CD deploy otomatis** — CI cuma menjalankan test, deploy tetap manual mengikuti `GO-LIVE.md`.
- **Filament (v3) dan Laravel (v11) beberapa versi mayor di belakang rilis terbaru** — bukan penghalang launch, tapi rencanakan jadwal upgrade beberapa bulan setelah go-live.
- Folder generated/local (`vendor`, `node_modules`, `.env`, dump foto mentah) diabaikan Git — lihat `.gitignore` di root proyek. **`public/build/` sengaja TIDAK diabaikan** (beda dari default Laravel) karena alur deploy cPanel proyek ini meng-upload hasil build langsung tanpa menjalankan `npm run build` di server — jalankan `npm run build` dan commit hasilnya sebelum deploy.

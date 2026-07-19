# BACKLOG LARAVEL MVP

## Sprint 0 - Persiapan

- [X] Buat repository Laravel baru.
- [X] Setup `.env`.
- [X] Setup database.
- [X] Install Filament.
- [X] Setup auth admin.
- [X] Setup Tailwind/Vite.
- [X] Setup base layout frontend.

## Sprint 1 - Core Data

- [X] Migration `users`.
- [X] Migration `media`.
- [X] Migration `categories`.
- [X] Migration `posts`.
- [X] Migration `pages`.
- [X] Migration `flight_schedules`.
- [X] Migration `public_service_links`.
- [X] Migration `contact_messages`.
- [X] Migration `redirects`.
- [X] Tambahkan unique index untuk slug `pages`, `posts`, `categories`, dan `redirects.old_path`.
- [X] Tambahkan foreign key untuk relasi media, kategori, author, dan featured image.
- [X] Tambahkan index untuk kolom yang sering difilter: `status`, `published_at`, `is_active`, `sort_order`.
- [X] Tetapkan convention status: draft, published, archived.
- [X] Seeder super admin.

## Sprint 2 - Admin Panel

- [X] Filament resource Pages.
- [X] Filament resource Posts.
- [X] Filament resource Categories.
- [X] Filament resource Media.
- [X] Filament resource Flight Schedules.
- [X] Filament resource Public Service Links.
- [X] Filament resource Contact Messages.
- [X] Filament resource Redirects.
- [X] Filament resource Users.
- [X] Policy/authorization admin per role.
- [X] Validasi form admin untuk slug unik, file upload, status publish, dan field SEO.
- [X] Proteksi admin agar hanya user aktif yang bisa login.
- [X] Dashboard widgets.

## Sprint 3 - Frontend Public

- [X] Header desktop.
- [X] Header mobile.
- [X] Footer.
- [X] Homepage.
- [X] Listing berita.
- [X] Detail berita.
- [X] Page template.
- [X] Jadwal penerbangan.
- [X] Empty state jadwal jika data detail resmi belum tersedia.
- [X] Kontak.
- [X] Search.
- [X] 404 page.
- [X] Rate limit form kontak dan search.
- [X] Validasi server-side semua input publik.
- [X] Pastikan semua external link memakai label/indikator yang jelas.

## Sprint 4 - Import Konten

- [X] Restore database WP lama di local database terpisah.
- [X] Tetapkan angka target import: jumlah post, page, media, dan dokumen yang benar-benar dibawa.
- [X] Export posts penting.
- [X] Export pages penting.
- [X] Extract featured images.
- [X] Copy media yang dipakai.
- [X] Bersihkan shortcode Elementor.
- [X] Import posts ke Laravel.
- [X] Import pages ke Laravel.
- [X] Import media metadata.
  - [X] Review manual konten halaman utama.
- [X] Inventaris dokumen PPID final dari media/live site.
- [X] Validasi tidak ada konten hasil import yang masih mengandung shortcode/plugin WordPress.
- [X] Validasi tidak ada link internal lama yang masih broken.

Status lokal 2026-07-18: 164 posts, 154 published posts, 30 pages, 69 media, dan 156 redirects sudah ada di database lokal. Sisa Sprint 4 adalah QA editorial/import, bukan plumbing import.

## Sprint 5 - SEO dan Redirect

- [X] Meta title dan description.
- [X] Canonical URL.
- [X] Open Graph.
- [X] Sitemap XML.
- [X] Robots.txt.
- [X] Middleware redirect 301.
- [X] Import redirect map.
- [X] Test URL lama utama.
- [X] Finalisasi redirect PPID nested yang masih pending.
- [X] Test redirect berita root slug lama ke `/berita/{slug}`.
- [X] Test redirect tidak loop dan tidak menimpa route Laravel yang valid.

Status 2026-07-18: Sprint 5 ditutup secara teknis. Validasi otomatis mencakup metadata canonical/Open Graph, sitemap berisi post/page published, dan redirect fallback tidak menimpa route valid.

## Sprint 5.5 - Security dan Hardening

- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false` saat production deployment disetujui.
- [X] Pastikan `.env`, dump SQL, folder backup, dan folder karantina tidak ikut deploy.
- [X] Batasi upload file berdasarkan MIME, ekstensi, dan ukuran.
- [X] Simpan file upload hanya lewat Laravel storage, bukan path bebas.
- [X] Tambahkan CSRF protection untuk semua form web.
- [X] Tambahkan rate limit untuk login admin dan form kontak.
- [X] Pastikan error publik tidak membocorkan stack trace atau path server.
- [X] Review permission folder `storage` dan `bootstrap/cache`.
- [X] Tambahkan backup database dan media sebelum go-live.

Status 2026-07-18: hardening aplikasi sudah diterapkan, tetapi Sprint 5.5 belum ditutup. Konfigurasi production aktual, permission Linux, backup, dan final verification tetap pending sampai deployment disetujui.

## Sprint 5.6 - Automated Test Minimal

- [ ] Feature test homepage, berita listing, detail berita, page statis, kontak, jadwal, dan PPID.
- [ ] Feature test form kontak tersimpan ke database.
- [ ] Feature test redirect middleware.
- [ ] Feature test admin login hanya untuk user aktif.
- [ ] Unit/feature test published scope untuk posts/pages.
- [ ] Unit/feature test hanya jadwal aktif yang tampil publik.
- [ ] Jalankan `php artisan test` sebelum staging dan production.

## Sprint 6 - QA dan Launch

- [ ] QA desktop.
- [ ] QA mobile.
- [ ] Test form kontak.
- [ ] Test admin CRUD.
- [ ] Test upload media.
- [ ] Test jadwal penerbangan.
- [ ] Test search.
- [ ] Test sitemap.
- [ ] Test redirect.
- [ ] Deploy staging.
- [ ] Final content review.
- [ ] Deploy production.
- [ ] Jalankan `php artisan migrate --force`, `storage:link`, `config:cache`, `route:cache`, dan `view:cache` di production.
- [ ] Verifikasi SSL, sitemap, robots, analytics/search console, dan error log setelah domain switch.
- [ ] Siapkan rollback plan: backup database, backup media, dan commit/tag release terakhir.

## Non-MVP

- [X] Audit log perubahan admin untuk data operasional.
- [X] Role granular: editor berita, admin konten, dan operator layanan dengan akses terbatas.
- [ ] Optimasi gambar otomatis.
- [ ] Dokumen PPID searchable.
- [X] Scheduled posts dan pages memakai `published_at` tanpa worker tambahan.
- [X] Preview konten post/page dengan signed URL 30 menit dan `noindex`.
- [ ] Backup otomatis.
- [ ] GA4/Search Console setup.

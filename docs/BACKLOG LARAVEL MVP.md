# BACKLOG LARAVEL MVP

## Sprint 0 - Persiapan

- [x] Buat repository Laravel baru.
- [x] Setup `.env`.
- [x] Setup database.
- [x] Install Filament.
- [x] Setup auth admin.
- [x] Setup Tailwind/Vite.
- [x] Setup base layout frontend.

## Sprint 1 - Core Data

- [x] Migration `users`.
- [x] Migration `media`.
- [x] Migration `categories`.
- [x] Migration `posts`.
- [x] Migration `pages`.
- [x] Migration `flight_schedules`.
- [x] Migration `public_service_links`.
- [x] Migration `contact_messages`.
- [x] Migration `redirects`.
- [x] Tambahkan unique index untuk slug `pages`, `posts`, `categories`, dan `redirects.old_path`.
- [x] Tambahkan foreign key untuk relasi media, kategori, author, dan featured image.
- [x] Tambahkan index untuk kolom yang sering difilter: `status`, `published_at`, `is_active`, `sort_order`.
- [x] Tetapkan convention status: draft, published, archived.
- [x] Seeder super admin.

## Sprint 2 - Admin Panel

- [x] Filament resource Pages.
- [x] Filament resource Posts.
- [x] Filament resource Categories.
- [x] Filament resource Media.
- [x] Filament resource Flight Schedules.
- [x] Filament resource Public Service Links.
- [x] Filament resource Contact Messages.
- [x] Filament resource Redirects.
- [x] Filament resource Users.
- [x] Policy/authorization admin per role.
- [x] Validasi form admin untuk slug unik, file upload, status publish, dan field SEO.
- [x] Proteksi admin agar hanya user aktif yang bisa login.
- [x] Dashboard widgets.

## Sprint 3 - Frontend Public

- [x] Header desktop.
- [x] Header mobile.
- [x] Footer.
- [x] Homepage.
- [x] Listing berita.
- [x] Detail berita.
- [x] Page template.
- [x] Jadwal penerbangan.
- [x] Empty state jadwal jika data detail resmi belum tersedia.
- [x] Kontak.
- [x] Search.
- [x] 404 page.
- [x] Rate limit form kontak dan search.
- [x] Validasi server-side semua input publik.
- [x] Pastikan semua external link memakai label/indikator yang jelas.

## Sprint 4 - Import Konten

- [x] Restore database WP lama di local database terpisah.
- [x] Tetapkan angka target import: jumlah post, page, media, dan dokumen yang benar-benar dibawa.
- [x] Export posts penting.
- [x] Export pages penting.
- [x] Extract featured images.
- [x] Copy media yang dipakai.
- [x] Bersihkan shortcode Elementor.
- [x] Import posts ke Laravel.
- [x] Import pages ke Laravel.
- [x] Import media metadata.
- [x] Review manual konten halaman utama.
- [ ] Inventaris dokumen PPID final dari media/live site.
- [x] Validasi tidak ada konten hasil import yang masih mengandung shortcode/plugin WordPress.
- [x] Validasi tidak ada link internal lama yang masih broken.

Status lokal 2026-07-18: 164 posts, 154 published posts, 30 pages, 69 media, dan 156 redirects sudah ada di database lokal. Sisa Sprint 4 adalah QA editorial/import, bukan plumbing import.

## Sprint 5 - SEO dan Redirect

- [x] Meta title dan description.
- [x] Canonical URL.
- [x] Open Graph.
- [x] Sitemap XML.
- [x] Robots.txt.
- [x] Middleware redirect 301.
- [x] Import redirect map.
- [x] Test URL lama utama.
- [x] Finalisasi redirect PPID nested yang masih pending.
- [x] Test redirect berita root slug lama ke `/berita/{slug}`.
- [x] Test redirect tidak loop dan tidak menimpa route Laravel yang valid.

Status 2026-07-18: Sprint 5 ditutup secara teknis. Validasi otomatis mencakup metadata canonical/Open Graph, sitemap berisi post/page published, dan redirect fallback tidak menimpa route valid.

## Sprint 5.5 - Security dan Hardening

- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false` saat production deployment disetujui.
- [x] Pastikan `.env`, dump SQL, folder backup, dan folder karantina tidak ikut deploy.
- [x] Batasi upload file berdasarkan MIME, ekstensi, dan ukuran.
- [x] Simpan file upload hanya lewat Laravel storage, bukan path bebas.
- [x] Tambahkan CSRF protection untuk semua form web.
- [x] Tambahkan rate limit untuk login admin dan form kontak.
- [x] Pastikan error publik tidak membocorkan stack trace atau path server.
- [x] Review permission folder `storage` dan `bootstrap/cache`.
- [x] Tambahkan backup database dan media sebelum go-live.

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

- [x] Audit log perubahan admin untuk data operasional.
- [x] Role granular: editor berita, admin konten, dan operator layanan dengan akses terbatas.
- [ ] Optimasi gambar otomatis.
- [ ] Dokumen PPID searchable.
- [x] Scheduled posts dan pages memakai `published_at` tanpa worker tambahan.
- [x] Preview konten post/page dengan signed URL 30 menit dan `noindex`.
- [ ] Backup otomatis.
- [ ] GA4/Search Console setup.

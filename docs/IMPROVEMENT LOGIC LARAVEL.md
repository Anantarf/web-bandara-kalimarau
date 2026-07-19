# IMPROVEMENT LOGIC LARAVEL

## Tujuan

Dokumen ini mencatat fitur dan logic yang sebaiknya dibuat lebih baik saat migrasi ke Laravel. Prinsipnya: jangan rebuild WordPress 1:1. Ambil kontennya, lalu bentuk ulang menjadi modul yang rapi, maintainable, dan mudah dipakai admin.

## Prinsip Rebuild

- Konten dipisahkan dari layout.
- Data penting dibuat terstruktur.
- Fitur yang cuma artefak plugin lama tidak dibawa.
- Admin harus bisa mengelola konten tanpa edit kode.
- Frontend harus cepat, bersih, dan tidak bergantung page builder.

## Improvement Prioritas MVP

### 1. Jadwal Penerbangan

Masalah saat ini:

- Jadwal tampil sebagai artikel/ringkasan.
- Data TablePress lama tidak valid.
- Tidak ada struktur data jam/rute/maskapai yang bisa difilter.

Solusi Laravel:

- Buat modul `flight_schedules`.
- Data dikelola dari admin.
- Tampil di homepage dan halaman jadwal.

Field minimal:

- maskapai.
- nomor penerbangan.
- tipe: keberangkatan/kedatangan.
- kota asal.
- kota tujuan.
- jam.
- hari operasi.
- status aktif.
- catatan.
- urutan tampil.

Logic tambahan:

- Hanya jadwal aktif yang tampil publik.
- Admin bisa nonaktifkan jadwal tanpa hapus data.
- Mobile tampil sebagai card, desktop sebagai tabel.
- Jika belum ada jadwal detail, tampilkan empty state yang jelas.
- Jangan generate jadwal detail dari artikel live; data resmi harus diinput manual/admin.

### 2. PPID

Masalah saat ini:

- PPID punya struktur sendiri tapi tercampur di WordPress.
- Banyak halaman/dokumen layanan publik butuh kategori yang jelas.

Solusi Laravel:

- Buat PPID sebagai section/module sendiri.
- Buat dokumen publik terstruktur.
- Jangan jadikan semua sebagai satu halaman panjang.

Model yang disarankan:

- `ppid_pages`
- `public_documents`
- `document_categories`

Field dokumen:

- judul.
- kategori.
- tahun.
- file.
- deskripsi.
- status aktif/arsip.
- tanggal publish.

Logic tambahan:

- Filter dokumen berdasarkan kategori/tahun.
- Search dokumen.
- Download counter opsional, bukan prioritas.
- Halaman prosedur tetap sebagai content page.

### 3. Hub Layanan dan Pengaduan

Masalah saat ini:

- Link layanan/pengaduan tersebar.
- Sebagian external, sebagian halaman internal.
- Admin sulit tahu mana yang aktif.

Solusi Laravel:

- Pakai model `public_service_links`.
- Semua layanan, survey, SIMADU, SP4N, IDPAS, dan link publik masuk satu modul.

Field:

- judul.
- deskripsi.
- kategori.
- url.
- tipe: internal/external.
- status aktif.
- icon.
- urutan tampil.

Kategori:

- pelayanan.
- pengaduan.
- survey.
- ppid.
- external.

Logic tambahan:

- External link diberi indikator di frontend.
- Link bisa dinonaktifkan tanpa hapus.
- Homepage quick links diambil dari data ini.

### 4. Berita

Masalah saat ini:

- Berita bercampur markup Elementor/plugin.
- Tidak ada kurasi yang rapi untuk homepage.
- Share button dan komentar muncul dari plugin.

Solusi Laravel:

- Buat modul `posts` yang lean.
- Konten berita disimpan bersih.
- Berita homepage dikurasi.

Field tambahan:

- is_featured.
- is_pinned.
- featured_image_id.
- seo_title.
- seo_description.
- published_at.
- status.

Logic tambahan:

- Auto excerpt dari content.
- Featured image fallback.
- Related posts berdasarkan kategori.
- Scheduled publish bisa masuk setelah MVP.
- Komentar tidak dibawa kecuali ada kebutuhan resmi.

### 5. Media

Masalah saat ini:

- Uploads fisik sekitar 1.7 GB.
- Banyak asset kemungkinan tidak dipakai.
- Media WordPress bercampur thumbnail, cache, dan generated files.

Solusi Laravel:

- Import hanya media yang dipakai.
- Pisahkan media gambar, dokumen, dan file publik.

Validasi upload:

- Gambar: jpg, jpeg, png, webp.
- Dokumen: pdf.
- Batasi ukuran file.
- Alt text wajib untuk gambar yang tampil publik.

Logic tambahan:

- Folder berdasarkan tahun/bulan.
- Image optimization setelah MVP.
- Jangan copy folder Elementor/cache.

### 6. SEO dan Redirect

Masalah saat ini:

- Riwayat SEO plugin ganda.
- URL lama perlu dijaga.
- Metadata tersebar di plugin.

Solusi Laravel:

- SEO dasar dibuat manual dan eksplisit.
- Redirect lama dikelola di tabel.

Logic:

- `redirects.old_path` ke `redirects.new_path`.
- Status code default 301.
- Middleware redirect sebelum 404.
- Sitemap otomatis.
- Canonical URL.
- Open Graph image.
- Meta description per page/post.

### 7. Kontak

Masalah saat ini:

- Kontak mostly statis.
- Form lama tergantung Contact Form 7.
- WhatsApp plugin dobel.

Solusi Laravel:

- Buat `contact_messages`.
- Satu WhatsApp CTA resmi.

Field:

- nama.
- email.
- nomor HP.
- subjek.
- pesan.
- status.
- submitted_at.

Logic:

- Status pesan: baru, dibaca, selesai.
- Email notification.
- Jika email tujuan belum dikonfigurasi, pesan tetap tersimpan di admin tanpa kirim email.
- Rate limit/spam protection sederhana.
- Nomor WhatsApp resmi: `0852 6214 6214` berdasarkan validasi live.

### 8. Admin Panel

Masalah saat ini:

- Admin WordPress terlalu banyak plugin.
- Fitur admin/login tumpang tindih.

Solusi Laravel:

- Filament admin panel.
- Resource dibuat sesuai modul.

Resource MVP:

- Pages.
- Posts.
- Categories.
- Media.
- Flight Schedules.
- Public Service Links.
- PPID Documents.
- Contact Messages.
- Redirects.
- Users.

Logic admin:

- Slug auto-generate tapi bisa diedit.
- Preview URL.
- Status draft/publish.
- Filter status.
- Search table.
- Audit log setelah MVP.

## Fitur Yang Jangan Dibuat Ulang

- WooCommerce/cart, kecuali terbukti dipakai.
- Visitor counter lokal.
- Elementor/page builder.
- Popup OptinMonster.
- Plugin share berat.
- Slider kompleks.
- Komentar berita.
- Admin/login customizer berlapis.
- Data TablePress lama.
- Cache/plugin metadata.
- Revision WordPress.

## Modul Tambahan Yang Disarankan

### `documents`

Untuk PPID, regulasi, laporan, formulir, dan file download publik.

### `public_service_links`

Untuk semua link layanan dan pengaduan.

### `redirects`

Untuk menjaga SEO dan URL lama.

### `settings`

Untuk data global:

- alamat.
- nomor telepon.
- WhatsApp.
- email.
- social links.
- footer weblink.
- logo.

### `featured_posts`

Bisa berupa flag `is_featured` di posts, tidak perlu tabel terpisah untuk MVP.

## Prioritas Implementasi Improvement

### Masuk MVP

- Flight schedules.
- Public service links.
- Contact messages.
- Redirects.
- PPID documents basic.
- Featured posts.
- Global settings basic.

### Setelah MVP

- Audit log.
- Scheduled publish.
- Image optimization otomatis.
- Advanced document search.
- Download counter dokumen.
- Role granular.
- Backup otomatis.

## Kesimpulan

Migrasi ke Laravel sebaiknya bukan memindahkan tampilan WordPress lama, tetapi memperbaiki struktur logic-nya. Modul yang paling penting untuk dibuat lebih baik adalah jadwal penerbangan, PPID, layanan/pengaduan, media, SEO redirect, dan admin content management.

# MIGRASI to LARAVEL

## Ringkasan

Website saat ini adalah WordPress untuk `kalimarau-airport.com` dengan tema aktif `materialis`, banyak konten Elementor, dan banyak plugin. Target migrasi yang disarankan adalah Laravel dengan admin panel, media manager, berita, halaman statis, dan jadwal penerbangan yang terstruktur.

Dokumen ini mencatat fitur, section, konten, dan data yang perlu dibawa atau diganti saat migrasi.

## Skala Konten Saat Ini

- Artikel/post: sekitar 165 post.
- Halaman/page: sekitar 41 halaman.
- Media attachment di database: sekitar 1124 attachment.
- File upload fisik: sekitar 7073 file, total sekitar 1.7 GB.
- Revisi WordPress: sekitar 1871 revision, tidak perlu dimigrasi.
- Menu item: sekitar 42 item.
- Elementor template/library: sekitar 9 item.
- Contact Form 7 form: sekitar 2 form.

Catatan: semua angka di atas sudah diverifikasi langsung dari isi `wpj0_posts` di database dump asli (bukan estimasi) — post 165 (154 publish + 10 draft + 1 auto-draft), page 41 (39 publish + 2 draft), attachment 1124, revision 1871, nav_menu_item 42, elementor_library 9, wpcf7_contact_form 2. Semua cocok persis.

## Struktur Navigasi Utama

Urutan dan label di bawah sudah dikonfirmasi persis dari 2 menu WordPress asli (`header Menu` 21 item, `ppid` 21 item, total pas 42 sesuai Skala Konten Saat Ini) — bukan tebakan dari tampilan visual.

### Beranda

- Hero/header dengan logo dan navigasi.
- Slider utama memakai Algori Video and Image Slider (bukan Smart Slider 3 — Smart Slider 3 sudah dikarantina/rusak dan tidak aktif).
- Section berita terkini dan terupdate.
- Section fasilitas.
- Section fasilitas kelompok rentan.
- Video YouTube profil/fasilitas.
- Section profile Bandara Kalimarau.
- Section unit kerja:
  - Unit Bangland / Bangunan dan Landasan.
  - Unit Elband / Elektronika Bandara.
  - Unit AMC / Apron Movement Control.
  - Unit AAB / Alat-alat Berat.
  - Unit Power House / Kelistrikan.
  - Unit QC / Quality Control Terminal.

### Berita

- Listing berita.
- Detail berita.
- Kategori berita.
- Load more / pagination.
- Featured image.
- Tanggal publikasi.
- Author.
- Excerpt.

### Profil

- Maklumat Pelayanan.
- Profil Bandara Kalimarau.
- Struktur Organisasi.
- Visi dan Misi.

### Pelayanan dan Kerjasama

- Pengajuan Pas Bandara, link eksternal/subdomain `https://idpas.kalimarau-airport.com` (dikonfirmasi auto-redirect ke HTTPS).
- Fasilitas Disewakan.
- Tarif Kebandarudaraan.
- Standar Pelayanan.
- Buku Tamu.

### Pengaduan

- Monev Kepuasan Pengguna Jasa / Survey Kepuasan Masyarakat Internal.
- Survey Kepuasan Eksternal Kemenhub.
- SIMADU.
- SP4N Lapor.
- Hasil dan Tindak Lanjut.

### PPID

PPID punya menu sendiri terpisah dari menu utama (`ppid` nav_menu, 21 item), dikonfirmasi dari database — bukan lagi dugaan:

- Beranda PPID.
- Tentang PPID:
  - Profil PPID.
  - Visi dan Misi.
  - Tugas dan Fungsi.
  - Struktur Organisasi (halaman terpisah dari "Struktur Organisasi" di menu utama Profil).
  - Struktur Organisasi PPID Pelaksana UPT.
  - Regulasi.
- Informasi Publik:
  - Informasi Berkala.
  - Informasi Setiap Saat (parent tanpa link langsung/dropdown).
  - Informasi Serta Merta.
  - Formulir Pengajuan Informasi.
- Pelayanan:
  - Maklumat Pelayanan & Standar Biaya.
  - Prosedur Permohonan Informasi.
  - Prosedur Permohonan Keberatan Informasi.
  - Prosedur Pengajuan Sengketa Informasi Publik.
  - Laporan Layanan Informasi Publik (parent tanpa link langsung/dropdown).
  - Laporan Kepuasan Pelayanan Informasi Publik (parent tanpa link langsung/dropdown).
- Kritik dan Saran.

Catatan: slug halaman "Struktur Organisasi" di bawah Tentang PPID adalah `/s/` — sudah dicek langsung ke live site, halaman ini valid dan isinya benar (profil BLU UPBU Kelas I Kalimarau, beda konten dari "Struktur Organisasi" di menu Profil yang fokus ke Dewan Pengawas). Bukan link rusak, tapi slug `/s/` terlalu pendek/tidak deskriptif untuk SEO — saat migrasi sebaiknya diganti slug baru yang lebih jelas (misal `/ppid/struktur-organisasi/`) lalu di-redirect 301 dari `/s/`, jangan dipertahankan apa adanya.

### Kontak

- Halaman kontak.
- Form kontak.
- Informasi alamat/telepon/email.
- Kemungkinan tombol WhatsApp.

## Konten Berita Yang Terlihat

Contoh topik berita yang harus dimigrasi:

- Jadwal penerbangan terbaru di Bandara Kalimarau.
- Diskon tarif harga tiket pesawat periode Nataru.
- Sosialisasi APAR dan Fire Blanket.
- Penyambutan penerbangan perdana Balikpapan - Berau - Balikpapan.
- Rute baru Super Air Jet.
- Inaugurasi penerbangan perdana Air Asia.
- Kunjungan kerja PT Integrasi Aviasi Solusi.
- Peringatan Hari Perhubungan Nasional.
- Air Asia segera hadir melayani penerbangan di Bandara Kalimarau.
- Rekap data pengiriman kargo ekspor komoditi hasil laut.
- Bandara Kalimarau meraih penghargaan dari KPPN Tanjung Redeb.
- Salam Kalimarau WOW.
- Semarak HUT RI.
- Kegiatan/agenda internal Bandara Kalimarau.

## Fitur WordPress Yang Perlu Diganti Di Laravel

### Wajib Untuk MVP

- Admin login.
- Dashboard admin sederhana.
- CRUD berita.
- CRUD halaman statis.
- Upload dan pilih gambar/media.
- Jadwal penerbangan terstruktur.
- Menu/navigation manager sederhana.
- Form kontak atau pengaduan.
- SEO dasar:
  - title.
  - meta description.
  - slug.
  - canonical URL.
  - Open Graph image.
- Redirect URL lama WordPress ke URL baru.

### Penting Setelah MVP

- Role user:
  - Super Admin.
  - Admin Konten.
  - Editor Berita.
- Audit log perubahan konten.
- Draft/published/scheduled status.
- Preview sebelum publish.
- Optimasi gambar otomatis.
- Sitemap XML.
- Robots.txt.
- Search berita/halaman.
- Analytics integration.
- WhatsApp floating button.
- Backup database dan media.

### Tidak Perlu Dibawa Apa Adanya

- Elementor layout mentah.
- WordPress revision.
- Cache plugin data.
- Visitor counter data lama.
- WooCommerce, kecuali ternyata ada transaksi/produk yang benar-benar dipakai.
- Plugin SEO ganda.
- Plugin builder/addons yang overlap.
- File backup, SQL dump, folder testing, dan file karantina.

## Model Data Laravel Yang Disarankan

### users

- id
- name
- email
- password
- role
- is_active
- last_login_at

### pages

- id
- title
- slug
- content
- excerpt
- featured_image_id
- status
- seo_title
- seo_description
- published_at

### posts

- id
- title
- slug
- content
- excerpt
- featured_image_id
- category_id
- author_id
- status
- seo_title
- seo_description
- published_at

### categories

- id
- name
- slug

### media

- id
- disk
- path
- filename
- mime_type
- size
- width
- height
- alt_text
- caption

### flight_schedules

- id
- airline
- flight_number
- route_from
- route_to
- departure_time
- arrival_time
- days
- type
- is_active
- sort_order

Type:

- departure
- arrival

### public_service_links

- id
- title
- slug
- description
- url
- category
- is_external
- sort_order

Contoh category:

- pelayanan
- pengaduan
- ppid
- survey

### contact_messages

- id
- name
- email
- phone
- subject
- message
- status
- submitted_at

### redirects

- id
- old_path
- new_path
- status_code

## Section Frontend Laravel

### Homepage

- Header + navigation.
- Hero/slider.
- Quick links layanan.
- Berita terkini.
- Jadwal penerbangan ringkas.
- Fasilitas.
- Video profil.
- Unit kerja.
- Kontak cepat / WhatsApp.
- Footer.

### Berita

- Grid/list berita.
- Filter kategori.
- Search.
- Pagination.
- Detail berita.
- Related posts.

### Profil Bandara

- Profil.
- Visi dan Misi.
- Struktur organisasi.
- Maklumat pelayanan.

### Layanan

- Fasilitas disewakan.
- Tarif kebandarudaraan.
- Standar pelayanan.
- Pengajuan pas bandara.
- Buku tamu.

### Pengaduan dan Survey

- Survey internal.
- Survey eksternal Kemenhub.
- SIMADU.
- SP4N Lapor.
- Hasil dan tindak lanjut.

### PPID

Struktur lengkap sudah dikonfirmasi dari database (lihat detail di bagian Struktur Navigasi Utama > PPID), ringkasnya 4 grup + 1 halaman mandiri:

- Tentang PPID (profil, visi misi, tugas fungsi, struktur organisasi x2, regulasi).
- Informasi Publik (informasi berkala, informasi setiap saat, informasi serta merta, formulir pengajuan informasi).
- Pelayanan (maklumat pelayanan & standar biaya, 3 halaman prosedur, 2 halaman laporan).
- Kritik dan Saran.

### Kontak

- Alamat.
- Email.
- Telepon.
- Maps.
- Form kontak.
- WhatsApp CTA.

## Arah UI Design

Target UI baru: website instansi bandara yang bersih, kredibel, cepat dibaca, dan mudah dikelola. Jangan meniru visual WordPress/Elementor lama secara mentah. Ambil kontennya, bukan kompleksitas layout-nya.

Catatan penting: UI harus nyaman untuk user awam. Hindari gaya visual yang terasa "AI generated": terlalu banyak gradient, card dekoratif, copy marketing, ilustrasi generik, dan animasi tanpa fungsi.

### Karakter Visual

- Modern institutional, bukan landing page startup.
- Profesional, terang, informatif, dan mudah dipindai.
- Dominan putih/netral dengan aksen biru transportasi/aviation.
- Gunakan foto nyata Bandara Kalimarau sebagai elemen visual utama.
- Hindari efek berlebihan, animasi berat, gradient ramai, dan card bertumpuk.
- Prioritaskan keterbacaan, aksesibilitas, dan performa mobile.
- Label dan flow harus mudah dipahami penumpang, keluarga penumpang, pemohon layanan, dan pencari informasi publik.

### Palet Warna Awal

- Primary: biru aviation.
- Secondary: cyan/langit atau teal tipis.
- Neutral: putih, abu muda, slate untuk teks.
- Accent: kuning/amber hanya untuk highlight penting.
- Danger/success/info mengikuti standar UI admin.

Catatan: warna final sebaiknya diambil dari logo Bandara Kalimarau dan diuji kontrasnya.

### Tipografi

- Font sans-serif modern dan mudah dibaca.
- Heading tegas, tidak terlalu dekoratif.
- Body text nyaman untuk berita dan halaman panjang.
- Jangan pakai ukuran hero terlalu besar di halaman internal.

### Layout Global

- Header sticky ringan atau normal header dengan navigasi jelas.
- Menu desktop horizontal dengan dropdown sederhana.
- Menu mobile off-canvas atau collapsible.
- Container maksimal sekitar 1120-1280px.
- Section full-width dengan inner content, bukan semua dibungkus card.
- Footer informatif dengan kontak, layanan, link penting, dan sosial/media.

### Homepage UI

- Hero memakai foto bandara/terminal/pesawat yang relevan.
- Hero berisi:
  - nama Bandara Kalimarau.
  - deskripsi singkat.
  - CTA ke jadwal penerbangan.
  - CTA ke layanan/pengaduan.
- Quick links untuk:
  - Jadwal Penerbangan.
  - Pengajuan Pas Bandara.
  - Survey Kepuasan.
  - PPID.
  - Kontak.
- Berita terkini tampil sebagai grid/list yang rapi.
- Jadwal penerbangan ringkas tampil sebagai tabel atau tab keberangkatan/kedatangan.
- Fasilitas tampil sebagai gallery/list informatif.
- Unit kerja tampil ringkas dengan video/link detail.

### Halaman Berita

- Listing berita dengan card sederhana:
  - thumbnail.
  - kategori.
  - tanggal.
  - judul.
  - excerpt.
- Detail berita:
  - judul jelas.
  - tanggal dan author.
  - featured image.
  - konten bersih.
  - share button opsional.
  - berita terkait.
- Jangan membawa markup Elementor lama.

### Halaman Statis

- Gunakan template content page yang konsisten.
- Breadcrumb.
- Sidebar opsional untuk halaman satu grup, seperti Profil atau Pelayanan.
- Konten panjang harus punya heading hierarchy yang jelas.
- Dokumen/download ditampilkan sebagai list file, bukan link acak di paragraf.

### Jadwal Penerbangan

- Jadwal harus menjadi data terstruktur, bukan HTML table manual.
- UI minimal:
  - tab Keberangkatan dan Kedatangan.
  - filter maskapai/rute.
  - tabel desktop.
  - card list di mobile.
- Kolom:
  - Maskapai.
  - Nomor penerbangan.
  - Jam.
  - Rute.
  - Hari/jadwal.
  - Status aktif.

### Layanan dan Pengaduan

- Layanan ditampilkan sebagai list/card sederhana berdasarkan kategori.
- External link diberi indikator jelas.
- Pengaduan/survey harus punya CTA yang jelas:
  - SIMADU.
  - SP4N Lapor.
  - Survey internal.
  - Survey Kemenhub.
- Jika form dibuat internal, tampilkan status submit yang jelas dan simpan pesan di admin.

### PPID

- Tampilkan sebagai halaman layanan publik yang formal.
- Section:
  - Profil PPID.
  - Daftar informasi publik.
  - Dokumen.
  - Alur permohonan informasi.
  - Kontak PPID.
- Dokumen harus bisa dicari/filter berdasarkan kategori.

### Admin UI

- Admin pakai Filament default dengan sedikit branding.
- Prioritas admin: cepat input konten, bukan visual custom berlebihan.
- Form harus punya:
  - preview slug.
  - upload featured image.
  - status draft/publish.
  - SEO fields.
  - validation jelas.

### Komponen UI Yang Perlu Dibuat

- Public header.
- Public footer.
- Breadcrumb.
- News card.
- Page hero.
- Quick link tile.
- Flight schedule table/card.
- Service link card.
- Media/document list.
- Contact form.
- Empty state.
- Error page 404.
- Search result item.

### Responsive dan Aksesibilitas

- Mobile-first.
- Navigasi mobile harus jelas dan tidak menutupi konten.
- Semua gambar punya alt text.
- Kontras teks cukup.
- Fokus keyboard terlihat.
- Button/link punya label jelas.
- Tabel jadwal harus nyaman dibaca di layar kecil.

### Performance UI

- Optimasi gambar sebelum tampil.
- Lazy-load gambar di bawah fold.
- Hindari slider berat jika tidak benar-benar perlu.
- CSS dan JS minimal.
- Jangan membawa asset Elementor lama yang tidak dipakai.

### Referensi Gaya

- Website bandara/instansi transportasi yang formal dan informatif.
- UI pemerintah/layanan publik yang clean.
- Dashboard admin Filament untuk back office.

## Admin Panel Laravel

Disarankan pakai Filament agar cepat dan maintainable.

Resource admin:

- Pages.
- Posts.
- Categories.
- Media.
- Flight Schedules.
- Public Service Links.
- Contact Messages.
- Redirects.
- Users.

Dashboard widgets:

- Total berita.
- Total halaman.
- Pesan kontak baru.
- Jadwal aktif.
- Media usage.

## Plugin/Fitur WP Yang Sedang Digunakan

Plugin yang terlihat di instalasi saat ini:

- Elementor.
- Essential Addons for Elementor.
- Premium Addons for Elementor.
- Royal Elementor Addons.
- ElementsKit Lite.
- Ele Custom Skin.
- Header Footer Elementor.
- Materialis Companion.
- Algori Video and Image Slider (slider hero aktual, lihat catatan di bawah).
- Contact Form 7.
- All in One SEO Pack.
- Google Site Kit.
- LiteSpeed Cache.
- WooCommerce.
- WP Table Builder.
- Add Search to Menu.
- OptinMonster (popup/lead-gen, perlu dicek apakah masih benar-benar dipakai atau sisa trial).
- Simple Share Buttons Adder (tombol share sosmed, belum tercatat sebagai fitur frontend di atas).
- WhatsApp chat/sticky button — ada 2 plugin sekaligus: `wa-sticky-button` dan `wp-whatsapp-chat`, perlu dipastikan mana yang aktif dipakai sebelum migrasi tombol WhatsApp.
- Visitor counter/statistics — ada 2 plugin sekaligus: `wps-visitor-counter` dan `visitors-traffic-real-time-statistics`, data lama tidak perlu dimigrasi (sudah sesuai kategori "Tidak Perlu Dibawa Apa Adanya").
- WPS Hide Login.
- Adminify.
- White Label CMS.
- Login Customizer.
- EmbedPress.
- Akismet.

Catatan (dikonfirmasi dari isi `wp_options` -> `active_plugins` di database dump asli, 32 plugin aktif):

- `smart-slider-3` sebenarnya tercatat AKTIF di database, tapi file plugin-nya sudah dikarantina/rusak — kemungkinan slider ini fatal error atau silent-fail di live site sekarang. `algori-image-video-slider` juga tercatat aktif berbarengan. **Perlu dicek manual di live site** slider mana yang benar-benar tampil sebelum menentukan referensi desain hero untuk Laravel.
- `wordpress-seo` (Yoast SEO) TIDAK ada di daftar `active_plugins` — berarti sudah nonaktif, meskipun tabel `wpj0_yoast_*` masih ada sisa datanya. SEO plugin yang benar-benar aktif adalah All in One SEO Pack, sesuai dokumen.
- `pdf-embedder` tercatat aktif di database tapi file plugin tidak ditemukan di folder — dikonfirmasi, sama seperti catatan sebelumnya.
- `visitors-traffic-real-time-statistics` ada di folder plugin tapi TIDAK aktif — yang aktif hanya `wps-visitor-counter`. Jadi bukan 2 plugin counter jalan bersamaan, cuma 1.
- `wa-sticky-button` dan `wp-whatsapp-chat` DUA-DUANYA aktif bersamaan (dikonfirmasi dari `active_plugins`) — perlu dicek manual mana yang benar-benar dipakai sebelum migrasi tombol WhatsApp, karena berpotensi render dobel.
- Uploads fisik dicek langsung: 7073 file, 1.7 GB — cocok dengan estimasi di bagian Skala Konten Saat Ini.

## Risiko Migrasi

- Banyak konten halaman berasal dari HTML/shortcode Elementor, perlu dibersihkan manual atau semi-otomatis.
- **Data jadwal penerbangan di database TIDAK bisa dipakai sebagai sumber migrasi.** Ditemukan 5 tabel dari plugin TablePress (plugin-nya sendiri sudah dihapus/tidak ada di folder plugin, datanya "yatim" di database) berjudul "Jadwal Pesawat", "Kedatangan", dsb, tanggal 2022-09-12. Setelah dicek isinya: data dummy/contoh (domain `contoh.kalimarau-airport.com`, baris kosong, placeholder generik "SETIAP HARI"), bukan jadwal riil terkini. Jadwal penerbangan yang benar-benar tampil di situs sekarang kemungkinan besar ditulis langsung sebagai HTML/Elementor di halaman, bukan dari tabel ini — perlu identifikasi manual halaman mana yang menampilkan jadwal aktual sebelum migrasi ke tabel `flight_schedules`.
- Media 1.7 GB perlu dipilah; jangan semua dibawa jika tidak dipakai.
- URL lama harus dipertahankan via redirect agar SEO dan link publik tidak rusak.
- Form survey/pengaduan kemungkinan beberapa hanya link eksternal, perlu dipetakan satu per satu.
- User WordPress lama tidak perlu dimigrasi kecuali akun admin valid.

## Inefisiensi WP Yang Jangan Diulang Di Laravel

Temuan dari audit database dan plugin asli — ini bukan fitur yang perlu dibawa, tapi kebiasaan/kondisi yang harus dihindari saat bangun versi Laravel:

- **Tracking pengunjung berlapis dan sebagian besar sampah**: tabel `ahc_*`, `wps_statistic`, `wsm_*` menyumpal **lebih dari 80% ukuran seluruh dump database** (122 ribu dari total 172 ribu baris cuma dari `ahc_*` saja), padahal plugin pemiliknya sudah tidak ada di folder plugin — murni data mati yang tidak pernah dibersihkan. Di Laravel: jangan pasang visitor-counter/analytics self-hosted sama sekali, cukup Google Site Kit/GA4 seperti yang sudah direncanakan, dan jangan biarkan tabel log tumbuh tanpa retensi/pruning.
- **Plugin dobel untuk fungsi yang sama, aktif bersamaan**: 2 plugin WhatsApp button (`wa-sticky-button` + `wp-whatsapp-chat`) aktif sekaligus → dua script/DOM element untuk satu tombol. Di Laravel cukup 1 komponen WhatsApp CTA, tidak perlu alternatif cadangan yang tetap running.
- **5 plugin Elementor addon aktif bersamaan** (Essential Addons, Premium Addons, Royal Elementor Addons, ElementsKit Lite, Ele Custom Skin) — masing-masing load CSS/JS sendiri di semua halaman meski cuma dipakai sebagian kecil widget, bikin halaman berat. Di Laravel tidak perlu page builder sama sekali — konten jadi data terstruktur + Blade component, jadi masalah ini otomatis hilang, bukan sesuatu yang perlu "diganti dengan library serupa".
- **4 plugin tumpang tindih untuk area admin/login** (WPS Hide Login, Login Customizer, White Label CMS, Adminify) — semua utak-atik hal yang sama (branding & keamanan login). Di Filament ini cukup 1 konfigurasi panel, tidak perlu plugin berlapis.
- **2 SEO plugin pernah terpasang bersamaan** (Yoast SEO nonaktif tapi tabelnya masih ada, All in One SEO Pack aktif) — riwayat plugin SEO ganda yang saling tumpang tindih. Rencana MVP sudah benar hanya pakai kolom meta manual, jangan tambah plugin SEO berat di Laravel.
- **Plugin ditinggal aktif meski file sudah hilang/rusak** (`smart-slider-3`, `pdf-embedder` tercatat aktif padahal file tidak ada) — tanda kebiasaan hapus/ganti plugin tanpa nonaktifkan dulu, berisiko fatal error diam-diam. Di Laravel: kalau suatu fitur dihapus, hapus juga lewat migration/config, jangan biarkan referensi menggantung.
- **Data dari plugin yang sudah dicopot tetap nyangkut di database** (5 tabel TablePress dummy, 1 Ninja Tables) — sudah dibahas di Risiko Migrasi. Kebiasaan ini juga berarti: proses cleanup di Laravel harus benar-benar hapus data terkait, bukan cuma uninstall package-nya.
- **1871 revisi WordPress menumpuk** — autosave/revision WP tidak pernah dibersihkan otomatis. Laravel tidak perlu sistem revisi konten sama sekali untuk skala ini (histori perubahan cukup lewat git untuk kode, dan `updated_at` untuk konten); kalaupun nanti perlu audit trail, itu sudah direncanakan sebagai fitur terpisah (audit log), bukan revision dump seperti WP.
- **OptinMonster (popup lead-gen) aktif** — fitur marketing untuk e-commerce/lead capture, kurang relevan untuk situs informasi bandara pemerintah dan menambah beban script. Jangan otomatis dibawa ke Laravel, evaluasi dulu apakah benar-benar dipakai/perlu sebelum direplikasi.



### Tahap 1 - Inventory Final

- Export daftar page, post, slug, tanggal, status.
- Export media yang benar-benar dipakai konten.
- Mapping menu lama ke menu baru.
- Mapping URL lama ke URL baru.
- Identifikasi form/link eksternal yang masih aktif.

### Tahap 2 - Build Laravel MVP

- Setup Laravel.
- Setup Filament.
- Buat model dan migration.
- Buat admin CRUD.
- Buat frontend public.
- Buat media upload.
- Buat jadwal penerbangan terstruktur.

### Tahap 3 - Import Konten

- Import post.
- Import page penting.
- Import featured image.
- Import dokumen penting.
- Bersihkan shortcode/HTML Elementor.
- Buat redirect.

### Tahap 4 - QA

- Cek semua halaman utama.
- Cek mobile responsive.
- Cek link dan tombol eksternal.
- Cek form.
- Cek sitemap.
- Cek broken image.
- Cek redirect URL lama.

### Tahap 5 - Go Live

- Freeze update konten di WordPress lama.
- Final import delta konten.
- Deploy Laravel.
- Switch domain.
- Monitor error log.
- Monitor analytics/search console.

## Prioritas MVP

1. Homepage.
2. Berita.
3. Halaman profil dan layanan utama.
4. Jadwal penerbangan.
5. Kontak dan pengaduan/link survey.
6. PPID.
7. Redirect URL lama.
8. Admin panel.

## Keputusan Teknis Awal

- Backend: Laravel.
- Admin: Filament.
- Database: MySQL/MariaDB.
- Frontend: Blade + Tailwind atau Blade + CSS custom.
- Media storage: local public disk dulu, bisa naik ke S3-compatible storage nanti.
- Auth admin: Laravel auth bawaan/Filament auth.
- Deploy: VPS/shared hosting Laravel-compatible.

## Detail Tech Stack

### Backend

- PHP 8.3.
- Laravel 11.
- Livewire (dipakai internal oleh Filament, tidak perlu setup manual terpisah).

### Admin Panel

- Filament 3 (panel builder, form, table, resource CRUD bawaan sudah cukup untuk semua resource admin di atas, tidak perlu bikin CRUD manual).
- Filament plugin tambahan hanya kalau ketemu kebutuhan nyata saat build (misal media library kalau `spatie/laravel-medialibrary` dirasa kurang lewat Filament upload field bawaan).

### Database

- MySQL 8 (samakan dengan versi yang tersedia di hosting/VPS target).
- Migration Laravel bawaan untuk schema, tidak perlu query builder terpisah.
- Gunakan unique index untuk slug publik dan `redirects.old_path`.
- Gunakan foreign key untuk relasi utama agar data yatim tidak terulang seperti di WordPress lama.
- Tambahkan index untuk kolom yang sering dipakai filter/sort: `status`, `published_at`, `is_active`, `sort_order`, dan `category_id`.
- Status konten dibuat eksplisit: `draft`, `published`, `archived`. Scheduled publish boleh ditambahkan setelah MVP.

### Security Baseline

- `APP_DEBUG=false` di production.
- `.env`, dump SQL, backup, dan folder karantina tidak boleh ikut public deploy.
- Semua form publik wajib validasi server-side dan CSRF.
- Login admin dan form kontak wajib rate limit.
- Upload file dibatasi MIME, ekstensi, ukuran, dan hanya disimpan lewat Laravel storage.
- File publik yang bisa diupload: gambar (`jpg`, `jpeg`, `png`, `webp`) dan dokumen (`pdf`) untuk MVP.
- Error publik tidak boleh menampilkan stack trace, path server, query, atau nilai env.
- Admin hanya bisa diakses user aktif dengan role yang jelas.
- External link harus ditandai jelas di frontend agar user paham keluar dari website utama.

### Frontend Public Site

- Blade + Tailwind CSS (lewat Vite, bawaan Laravel starter).
- Alpine.js hanya kalau perlu interaktivitas kecil (dropdown, slider toggle), sudah include otomatis kalau pakai Livewire/Filament.
- Slider hero: swiper.js atau plugin Tailwind-based ringan, jangan port Smart Slider 3 apa adanya.
- Tidak perlu SPA/Inertia/Vue/React, konten mostly server-rendered dan SEO-sensitive.

### Media & File

- Laravel filesystem, disk `public` untuk awal.
- `spatie/laravel-medialibrary` untuk attach media ke posts/pages kalau butuh multiple image per record; kalau cuma 1 featured image per record, cukup kolom `featured_image_id` yang sudah didesain, skip package ini dulu.
- Image resize/optimize: `spatie/laravel-image-optimizer` atau Intervention Image, tambahkan saat masuk tahap "Optimasi gambar otomatis" di fitur Penting Setelah MVP, bukan dari awal.

### SEO

- Meta tag manual di Blade layout (title, description, canonical, OG image) dari kolom `seo_title`/`seo_description` yang sudah ada di model, tidak perlu package SEO tambahan untuk MVP.
- Sitemap: `spatie/laravel-sitemap`, generate on-demand atau via scheduled command, bukan realtime.

### Auth

- Laravel auth bawaan (breeze-style) untuk login admin, Filament pakai auth guard yang sama.
- Tidak perlu Sanctum/Passport kecuali nanti ada kebutuhan API eksternal (misal integrasi jadwal penerbangan dari sistem lain).

### Redirect URL Lama

- Middleware/route table sederhana baca dari tabel `redirects`, redirect 301. Tidak perlu package khusus.

### Testing

- Pest atau PHPUnit bawaan Laravel, cukup test untuk model penting (flight_schedules, redirects) dan route utama.
- Minimum test MVP:
  - public route homepage, berita, page, jadwal, PPID, dan kontak.
  - form kontak tersimpan ke database.
  - redirect lama menghasilkan 301 ke URL baru.
  - admin login ditolak untuk user nonaktif.
  - hanya konten `published` yang tampil publik.
  - hanya jadwal `is_active` yang tampil publik.

### Deploy & Ops

- Target: VPS (lebih fleksibel untuk queue/scheduler) atau shared hosting cPanel yang support Laravel (via document root ke `public/`).
- Web server: Nginx + PHP-FPM kalau VPS.
- Queue: `database` driver cukup untuk awal (kirim email form kontak, dsb), tidak perlu Redis/Horizon di skala ini.
- Cache: `file` atau `database` driver, upgrade ke Redis kalau traffic naik signifikan.
- Backup: `spatie/laravel-backup` untuk database + media, sesuai kebutuhan "Backup database dan media" di fitur Penting Setelah MVP.
- SSL: Let's Encrypt.
- Production command minimal: `composer install --no-dev`, `php artisan migrate --force`, `php artisan storage:link`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
- Sebelum switch domain wajib ada backup database, backup media, dan rollback path ke versi WordPress lama atau release Laravel sebelumnya.

Skipped: Redis, Horizon, S3, API auth (Sanctum/Passport), SPA framework — tambahkan kalau kebutuhan nyata muncul saat build/QA, bukan dari awal.

## Role & Permission

- Package: `spatie/laravel-permission` + `filament-shield` (generate policy otomatis dari Filament resource, tidak perlu tulis policy manual satu-satu).

Role:

- **Super Admin** — akses semua resource, termasuk kelola user dan role.
- **Admin Konten** — CRUD pages, posts, categories, media, flight schedules, public service links, contact messages. Tidak bisa kelola user.
- **Editor Berita** — CRUD posts saja (create/edit/delete draft sendiri). Publish langsung diizinkan untuk tim kecil ini, tidak pakai approval workflow berlapis.

## Git & Deploy Workflow

- Branch: `main` untuk production, branch fitur per task lalu merge ke `main`.
- Deploy: manual via SSH — `git pull && composer install --no-dev && php artisan migrate --force && php artisan optimize`.
- CI/CD (GitHub Actions dsb.) belum perlu untuk tim sekecil ini, tambahkan kalau kontributor bertambah dan butuh gate otomatis sebelum merge.
- Staging: satu subdomain di VPS yang sama, dipakai untuk QA (Tahap 4) sebelum switch domain di Tahap 5.

## Catatan Cleanup WP Saat Ini

- Root WordPress sudah dibersihkan dari file aneh dan dump publik.
- Uploads sudah diproteksi dari eksekusi PHP.
- Folder karantina tidak boleh ikut diupload ke hosting baru.
- Database lama masih perlu dipakai sebagai sumber konten migrasi.

## Acceptance Criteria MVP

MVP Laravel dianggap selesai jika semua poin ini terpenuhi:

- Semua halaman utama dari menu lama tersedia di Laravel atau diarahkan ke link eksternal yang benar.
- Homepage tampil rapi di desktop dan mobile.
- Berita bisa dibuat, diedit, dipublish, dan dibuka di frontend.
- Minimal konten berita penting berhasil diimpor dengan slug dan gambar utama.
- Halaman statis penting berhasil dibuat ulang tanpa shortcode Elementor.
- Jadwal penerbangan tampil dari tabel `flight_schedules`, bukan dari HTML manual.
- Link `idpas.kalimarau-airport.com` tetap tersedia sebagai external link selama aplikasi subdomain belum ikut dimigrasi.
- Form kontak/pengaduan dasar bisa menerima submission dan masuk ke admin.
- Admin Filament bisa dipakai untuk kelola pages, posts, media, jadwal, layanan/link publik, redirect, dan user.
- Redirect URL lama utama berjalan 301.
- Sitemap XML dan meta dasar tersedia.
- Tidak ada file WP, dump SQL, folder karantina, atau asset Elementor lama yang ikut deploy ke Laravel.
- Mobile navigation, search, dan halaman berita bisa dipakai tanpa layout pecah.
- Upload file tervalidasi dan tidak bisa menjalankan file PHP/script dari folder publik.
- Form kontak punya validasi, rate limit, dan tetap menyimpan pesan meskipun email tujuan belum dikonfigurasi.
- Admin hanya bisa diakses user aktif sesuai role.
- Test minimal MVP lulus sebelum staging dan production.
- Production berjalan dengan `APP_DEBUG=false` dan tidak ada error publik yang membocorkan detail server.

## Data Yang Masih Perlu Diverifikasi Manual

Sebelum build turunan dan mulai coding, data berikut masih perlu dipastikan:

- Daftar final semua halaman yang benar-benar ingin dibawa, dari 41 halaman WP.
- Daftar post yang wajib diimpor semua vs hanya post terbaru/penting.
- Jadwal penerbangan aktual yang benar; data TablePress lama tidak bisa dipercaya.
- Link eksternal aktif:
  - `idpas.kalimarau-airport.com`.
  - SIMADU.
  - SP4N Lapor.
  - Survey internal.
  - Survey Kemenhub.
- Nomor WhatsApp resmi yang akan dipakai di tombol CTA.
- Email tujuan form kontak.
- Struktur PPID dan dokumen yang masih berlaku.
- Logo final, foto hero, dan asset brand resmi.
- Hosting target: VPS atau shared hosting Laravel-compatible.
- Apakah WooCommerce benar-benar tidak dipakai. Jika tidak dipakai, jangan dimigrasi.

Catatan resolusi 2026-07-17: status data yang belum terkunci sudah dipisahkan di `DATA RESOLUTION STATUS.md`. Tidak ada blocker untuk mulai build MVP; jadwal detail dan email form bisa dibuat sebagai konfigurasi/admin input, sedangkan IDPAS tetap external.

## File Turunan Yang Perlu Dibuat Setelah Dokumen Ini

Dokumen ini sudah cukup sebagai dokumen induk. File turunan yang perlu dibuat agar build lebih terarah:

1. `SITEMAP LARAVEL.md`
   - daftar halaman final, URL baru, URL lama, status migrasi, dan prioritas.
2. `WIREFRAME UI.md`
   - struktur layout tiap template utama: homepage, listing berita, detail berita, page, jadwal, PPID, kontak.
3. `DATA MIGRATION PLAN.md`
   - mapping tabel/field WordPress ke tabel Laravel, strategi import media, dan aturan bersih-bersih shortcode.
4. `BACKLOG LARAVEL MVP.md`
   - task teknis yang bisa langsung dikerjakan per sprint/batch.
5. `REDIRECT MAP.md`
   - daftar URL lama ke URL baru untuk menjaga SEO.
6. `IMPROVEMENT LOGIC LARAVEL.md`
   - daftar fitur dan logic yang tidak sekadar dimigrasi, tetapi dibuat lebih baik di Laravel.
7. `DATA RESOLUTION STATUS.md`
   - keputusan final untuk data yang belum bisa dikunci dari sumber publik.

eekbsrekabereasrb

# DATA MIGRATION PLAN

## Prinsip

Migrasi data tidak boleh membawa kekacauan WordPress ke Laravel. Ambil konten yang bernilai, bersihkan markup, lalu simpan ke struktur data baru.

## Sumber Data

- SQL dump WordPress lama yang sudah dikarantina.
- Folder `wp-content/uploads`.
- Halaman live jika masih bisa diakses untuk verifikasi tampilan aktual.
- Crawl live site sebelum freeze, karena live site menampilkan berita 2026 yang harus dipastikan ada di dump terbaru.

## Data Yang Dibawa

### Posts

Ambil:

- title.
- slug.
- content bersih.
- excerpt.
- published_at.
- featured image.
- author default.
- category jika relevan.
- SEO title/description jika mudah diekstrak.

Buang:

- revision.
- autosave.
- Elementor metadata mentah.
- visitor counter metadata.
- plugin cache metadata.

### Pages

Ambil halaman utama:

- homepage content sebagai referensi, bukan diimpor mentah.
- profil.
- maklumat pelayanan.
- struktur organisasi.
- visi misi.
- fasilitas disewakan.
- tarif kebandarudaraan.
- standar pelayanan.
- buku tamu.
- survey/pengaduan.
- PPID.
- kontak.

Buang:

- shortcode Elementor.
- duplicated inline CSS.
- widget wrapper.
- form plugin raw config.

### Media

Ambil:

- featured image untuk post/page.
- dokumen publik yang masih dipakai.
- logo dan brand asset.
- gambar fasilitas dan unit kerja.

Jangan langsung copy semua 1.7 GB kecuali dibutuhkan.

### Flight Schedules

Jangan percaya data TablePress lama.

Sumber final harus diverifikasi manual dari:

- halaman live.
- pihak pengelola.
- dokumen jadwal resmi terbaru.

Masukkan ke tabel `flight_schedules` secara manual/import CSV setelah valid.

Validasi live 2026 menunjukkan post jadwal terbaru hanya berisi daftar maskapai dan rute, bukan tabel jam terstruktur. Jadi seed awal jadwal detail harus datang dari sumber resmi/manual, bukan hasil parsing otomatis.

## Mapping WordPress ke Laravel

| WordPress                               | Laravel                             | Catatan                              |
| --------------------------------------- | ----------------------------------- | ------------------------------------ |
| `wpj0_posts` post_type `post`       | `posts`                           | Filter status publish.               |
| `wpj0_posts` post_type `page`       | `pages`                           | Pilih halaman penting.               |
| `wpj0_posts` post_type `attachment` | `media`                           | Hanya media terpakai.                |
| `wpj0_terms` + taxonomy               | `categories`                      | Untuk kategori berita.               |
| `wpj0_postmeta` featured image        | `posts.featured_image_id`         | Resolve attachment path.             |
| AIOSEO meta                             | `seo_title`, `seo_description`  | Opsional.                            |
| Menu item                               | hardcoded/config navigation         | Jangan bawa struktur WP menu mentah. |
| Contact Form 7                          | `contact_messages` + Laravel form | Rebuild.                             |

## Cleaning Rules

- Hapus shortcode seperti `[smartslider3 ...]`, `[hfe_template ...]`, `[table ...]`.
- Hapus inline style Elementor yang tidak dibutuhkan.
- Convert absolute URL lama ke relative path jika masih internal.
- Ganti `http://kalimarau-airport.com` ke `https://kalimarau-airport.com` untuk referensi lama.
- Pastikan gambar memakai path media Laravel.
- Rapikan heading: satu H1 per halaman, subheading H2/H3.
- Hapus empty paragraph dan duplicated whitespace.

## Import Strategy

1. Restore SQL dump ke database lokal `wp_kalimarau_legacy`.
2. Buat command Laravel `legacy:import-posts`.
3. Buat command Laravel `legacy:import-pages`.
4. Buat command Laravel `legacy:import-media`.
5. Simpan mapping legacy ID ke ID Laravel.
6. Generate redirect map dari slug lama.
7. Review manual halaman penting.

## Target Import Yang Harus Dikunci

Sebelum import final, tetapkan angka target agar hasil migrasi bisa diaudit:

- Jumlah post publish yang dibawa.
- Jumlah post draft yang dibuang atau dipertahankan sebagai draft.
- Jumlah page utama yang dibuat ulang.
- Jumlah media featured image yang benar-benar dipakai.
- Jumlah dokumen PPID/regulasi/formulir/laporan yang dibawa.
- Jumlah redirect halaman utama, PPID, dan berita.

Catatan:

- Jangan pakai angka attachment WordPress mentah sebagai target media final, karena folder uploads berisi thumbnail, cache, dan file tidak terpakai.
- Jika live site punya post 2026 yang tidak ada di dump lokal, ambil dari dump terbaru atau crawl sebelum freeze.

## Validasi

- Jumlah post import sesuai target.
- Jumlah page import sesuai target.
- Jumlah media dan dokumen import sesuai target yang sudah dikunci.
- Semua post punya slug unik.
- Semua page punya slug unik.
- Semua URL internal tidak broken.
- Featured image tampil.
- Halaman utama tidak mengandung shortcode WP.
- Tidak ada referensi asset dari folder karantina.
- Tidak ada referensi domain/path WordPress lama untuk asset internal yang sudah dimigrasi.
- Tidak ada file `.php`, `.sql`, `.zip`, backup, atau cache plugin yang ikut masuk storage Laravel publik.
- Minimal sampel manual: homepage, 10 berita terbaru, 10 berita lama, semua halaman profil/layanan/pengaduan, dan semua halaman PPID.

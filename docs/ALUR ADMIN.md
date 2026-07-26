# Alur Penggunaan Admin Panel

Panel admin ada di **`/admin`**, dibangun pakai Filament 3 + Filament Shield (Spatie Permission). Setiap menu yang tampil ke seorang pengguna ditentukan oleh *role*-nya — bukan semua pengguna melihat menu yang sama.

## 1. Role dan siapa yang boleh apa

Cuma ada 2 role:

| Role | Bisa akses | Tidak bisa akses |
|---|---|---|
| **super_admin** | Semuanya, tanpa batas | — |
| **admin** | Kategori, Halaman, Berita, Media, Jadwal Penerbangan, Layanan Publik, Pesan Masuk — penuh (lihat/buat/ubah/hapus) | Pengguna, Redirect, Audit Log |

Role didefinisikan di `database/seeders/RoleSeeder.php`. Kalau butuh role baru atau ubah akses suatu role, di situ tempatnya — bukan diutak-atik manual lewat UI.

**Prinsipnya:** `admin` menangani semua konten (berita, halaman) dan layanan (jadwal penerbangan, layanan publik, pesan masuk) sehari-hari. `super_admin` dipegang IT/penanggung jawab teknis untuk hal-hal sensitif (kelola pengguna, redirect, audit log). `admin` tidak akan pernah melihat menu "Redirect" atau "Pengguna", jadi tidak perlu takut bingung dengan menu yang tidak relevan.

## 2. Menu di sidebar (dikelompokkan per navigation group)

**Tampilan Depan**
- **Statistik Bandara** — angka-angka yang tampil di homepage (jumlah penumpang, penerbangan, dsb).

**Konten Website**
- **Kategori** — kategori untuk Berita.
- **Berita** — artikel berita/pengumuman yang tampil di `/berita`.
- **Halaman** — halaman statis (Profil Bandara, Fasilitas, PPID, dll). Termasuk halaman PPID yang di-nest di bawah `/ppid/...`.
- **Media** — pustaka gambar/file yang dipakai lintas halaman.

**Layanan & Data**
- **Jadwal Penerbangan** — hanya yang `aktif` yang tampil ke publik.
- **Layanan Publik** — daftar link/layanan yang ditampilkan di beranda.
- **Dokumen PPID** — file PDF/dokumen resmi (maks 10MB, tipe pdf/doc/docx).
- **Fasilitas Bandara** — data fasilitas yang tampil di homepage dan `/fasilitas-bandara`.
- **Pesan Masuk** — pesan dari form kontak `/kontak`.

**Sistem & Akses** *(super_admin only, kecuali disebutkan lain)*
- **Pengguna** — akun admin dan role-nya.
- **Redirect** — peta URL lama → baru (peninggalan migrasi dari WordPress), lihat penjelasan di bawah.
- **Audit Log** — jejak setiap perubahan data admin (siapa, kapan, ubah apa).

## 3. Alur kerja Halaman & Berita (yang paling sering dipakai)

Field **Status** ada di setiap Halaman/Berita, dengan 3 pilihan:

1. **Draf** — belum tampil ke publik. Kalau ada halaman/berita yang statusnya draf, mengaksesnya lewat URL publik akan menghasilkan **404** (ini pernah kejadian nyata di proyek ini — 12 halaman PPID lupa di-publish dan semuanya 404 sampai ditemukan dan diperbaiki).
2. **Diterbitkan** — tampil ke publik begitu `Tanggal Publikasi` terlewati.
3. **Diarsipkan** — pernah terbit, sekarang disembunyikan lagi.

**Tips penting:** field **Tanggal Publikasi** bisa diisi tanggal di masa depan untuk menjadwalkan publikasi otomatis — tidak perlu ingat balik lagi di hari-H.

**Sebelum publish, cek dulu tampilannya:** tombol **Preview** di halaman edit Halaman/Berita membuka link sementara (berlaku 30 menit) yang menampilkan halaman itu persis seperti tampilan publik, meski statusnya masih draf. Berguna untuk cek layout/gambar sebelum menekan "Diterbitkan".

## 4. Alur kerja Pesan Masuk (form kontak)

Field **Status** pada tiap pesan: **Baru** → **Dibaca** → **Dibalas** → **Diarsipkan**. Ini murni penanda progres internal (tidak mengirim balasan otomatis) — ubah status setelah pesan itu benar-benar ditindaklanjuti secara manual (telepon/email/WhatsApp), supaya tim tahu mana yang masih perlu direspons.

## 5. Redirect — apa itu dan kenapa masih ada

Situs ini dulu WordPress, lalu pindah ke Laravel. Tabel Redirect adalah peta "kalau ada yang buka URL lama, arahkan ke URL baru" — supaya link lama yang sudah ter-index Google atau dibagikan orang tidak berujung 404. Sempat berisi 154 baris (semuanya sisa artikel berita WordPress lama, sudah dibersihkan). Mekanismenya sengaja dipertahankan meski datanya kosong, karena sewaktu-waktu ada slug halaman/berita yang berubah lagi di masa depan, ini yang mencegah 404 tanpa kerja tambahan. Hanya `super_admin` yang melihat menu ini, jadi tidak akan membingungkan role `admin`.

## 6. Audit Log

Setiap perubahan lewat admin (kecuali data sensitif seperti password) otomatis tercatat: siapa, kapan, aksi apa, nilai sebelum/sesudah. Berguna untuk investigasi kalau ada perubahan tak terduga — cek di sini dulu sebelum tanya-tanya siapa yang mengubah apa.

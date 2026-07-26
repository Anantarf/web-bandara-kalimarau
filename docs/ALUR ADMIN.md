# Alur Penggunaan Admin Panel

Panel admin ada di **`/admin`**, dibangun pakai Filament 3 + Spatie Permission. Sejak panel disederhanakan, menunya flat (tidak dikelompokkan per kategori) dan cuma mencakup hal-hal yang benar-benar dikerjakan staf sehari-hari.

## 1. Role dan siapa yang boleh apa

Cuma ada 2 role, didefinisikan di `database/seeders/RoleSeeder.php`:

| Role | Bisa akses |
|---|---|
| **super_admin** | Semuanya, tanpa batas — termasuk Pengguna dan Riwayat Aktivitas |
| **admin** | Berita, Jadwal Penerbangan, Pesan Masuk, Statistik Bandara — penuh (lihat/buat/ubah/hapus) |

**Prinsipnya:** `admin` menangani konten dan layanan yang berubah setiap hari (berita, jadwal, pesan masuk). `super_admin` dipegang IT/penanggung jawab teknis untuk hal-hal sensitif (kelola akun pengguna, lihat riwayat aktivitas). Kalau butuh role baru atau ubah akses suatu role, edit `RoleSeeder.php` — bukan diutak-atik manual lewat UI.

## 2. Menu di sidebar

- **Dasbor** — halaman utama setelah login.
- **Berita** — artikel/pengumuman yang tampil di `/berita`.
- **Jadwal Penerbangan** — hanya yang `Aktif` yang tampil ke publik.
- **Pesan Masuk** — pesan dari form kontak `/kontak`.
- **Statistik Bandara** — angka-angka yang tampil di homepage.
- **Pengguna** *(super_admin only)* — akun admin dan role-nya.
- **Riwayat Aktivitas** *(super_admin only)* — jejak setiap perubahan data admin.

## 3. Penting: banyak halaman publik sekarang TIDAK dikelola lewat admin

Halaman statis (Profil Bandara, Fasilitas, semua halaman PPID), Fasilitas Bandara, Dokumen PPID, Media, Layanan Publik, dan peta Redirect **masih ada dan masih tampil normal di situs publik** — modelnya, datanya, dan halamannya tidak dihapus. Yang dihapus cuma layar CRUD-nya di `/admin` (resource `PageResource`, `FacilityResource`, `PpidDocumentResource`, `MediaResource`, `PublicServiceLinkResource`, `CategoryResource`, `RedirectResource` — semuanya sudah tidak ada).

Konsekuensinya: **konten-konten itu sekarang cuma bisa diubah lewat akses langsung ke database** (`php artisan tinker`, atau klien SQL), bukan lewat form di panel admin. Kalau suatu saat perlu mengubah teks/gambar di halaman PPID atau menambah fasilitas baru, itu harus dikerjakan oleh yang punya akses server/database — bukan sesuatu yang bisa didelegasikan ke staf lewat panel admin lagi.

## 4. Alur kerja Berita

Field **Status**: **Draf** (belum tampil publik — mengaksesnya lewat URL akan 404), **Diterbitkan** (tampil begitu `Tanggal Publikasi` terlewati, bisa dijadwalkan ke masa depan), **Diarsipkan** (pernah terbit, disembunyikan lagi).

**Kategori** sekarang otomatis — setiap berita baru otomatis masuk kategori "Berita" default (di-seed lewat `DatabaseSeeder`), tidak ada lagi pilihan kategori manual di form (karena `CategoryResource` sudah dihapus).

**Sebelum publish, cek dulu tampilannya:** tombol **Preview** di halaman edit Berita membuka link sementara (berlaku 30 menit) yang menampilkan halaman itu persis seperti tampilan publik, meski statusnya masih draf.

## 5. Alur kerja Pesan Masuk (form kontak)

Field **Status**: **Baru** → **Dibaca** → **Dibalas** → **Diarsipkan**. Murni penanda progres internal (tidak mengirim balasan otomatis) — ubah status setelah pesan itu benar-benar ditindaklanjuti secara manual (telepon/email/WhatsApp).

## 6. Riwayat Aktivitas

Setiap perubahan lewat admin (kecuali data sensitif seperti password) otomatis tercatat: siapa, kapan, aksi apa, nilai sebelum/sesudah. Berguna untuk investigasi kalau ada perubahan tak terduga.

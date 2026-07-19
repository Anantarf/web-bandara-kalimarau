# Desain: Kategori Kontak

**Status:** Disetujui, siap eksekusi
**Konteks:** Sub-project #1 dari rencana penyamaan fitur dengan aptpairport.id. Field "Subjek Pesan" (teks bebas) pada form kontak diganti jadi kategori tetap, mengikuti pola situs referensi.

## Cakupan

Ganti field `subject` (teks bebas) di form kontak & tabel `contact_messages` menjadi `category` (pilihan tetap): **Informasi, Keluhan, Saran, Apresiasi**.

Tidak ada perubahan pada: controller, route, policy, rate limiting, atau alur audit log — hanya field ini yang berubah bentuk dan nama.

## Perubahan

1. **Migration** — rename kolom `subject` → `category` di tabel `contact_messages`. Tabel saat ini kosong, tidak ada risiko kehilangan data.
2. **Validasi** (`app/Http/Requests/StoreContactRequest.php`) — `category` wajib diisi, dibatasi `Rule::in(['informasi','keluhan','saran','apresiasi'])`. Pesan error bahasa Indonesia disesuaikan.
3. **Model** (`app/Models/ContactMessage.php`) — `$fillable`: `subject` → `category`.
4. **Form publik** (`resources/views/contact/index.blade.php`) — input teks "Subjek Pesan" diganti `<select>` dropdown 4 opsi berlabel Indonesia (value = slug: `informasi`, `keluhan`, `saran`, `apresiasi`).
5. **Admin panel** (`app/Filament/Resources/ContactMessageResource.php`):
   - Form: `TextInput::make('subject')` → `Select::make('category')` (disabled, tampilan saja — pesan masuk dari publik tidak diedit isinya oleh admin).
   - Table: kolom `subject` → `category`, ditampilkan sebagai badge berwarna per kategori (pola sama seperti kolom `status`).
   - Filter: tambah `SelectFilter` untuk `category`.
6. **Test** (`tests/Feature/AuditLogTest.php`) — baris yang mengisi `'subject' => 'Pertanyaan'` diubah ke `'category' => 'informasi'`.

## Nilai kategori

| Slug (DB) | Label (UI) |
|---|---|
| `informasi` | Informasi |
| `keluhan` | Keluhan |
| `saran` | Saran |
| `apresiasi` | Apresiasi |

## Verifikasi

- `php artisan test` — seluruh suite tetap hijau, termasuk `AuditLogTest` yang disesuaikan.
- `vendor/bin/pint --test` — bersih.
- Manual: submit form kontak publik dengan tiap kategori, cek tampil benar di admin panel dengan badge warna & filter berfungsi.

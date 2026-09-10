# Bandara Kalimarau — Official Website

Website resmi **Bandara Kalimarau** (Berau, Kalimantan Timur) yang dibangun menggunakan **Laravel 11** dan **Filament 3**. Proyek ini merupakan migrasi modern dari situs WordPress lama dengan peningkatan performa, keamanan, dan pengalaman pengguna (*user experience*).

---

## 📚 Dokumentasi Utama

Dokumentasi lengkap proyek ini dikelompokkan di dalam folder [`docs/`](docs/):

| Informasi yang Dicari | Baca Dokumen |
|---|---|
| **Ringkasan Fitur & Arsitektur** | [`docs/README.md`](docs/README.md) |
| **Checklist & Runbook Deployment (Go-Live)** | [`docs/GO-LIVE.md`](docs/GO-LIVE.md) |
| **Panduan Penggunaan Admin Panel** | [`docs/ALUR ADMIN.md`](docs/ALUR%20ADMIN.md) |
| **Status Fitur & Backlog Proyek** | [`docs/BACKLOG LARAVEL MVP.md`](docs/BACKLOG%20LARAVEL%20MVP.md) |
| **Visi Produk & Panduan Desain** | [`PRODUCT.md`](PRODUCT.md) |

---

## 🛠️ Teknologi & Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Admin Panel**: Filament v3 (Spatie Permission & Audit Logs)
- **Frontend**: Blade, Alpine.js, Tailwind CSS (Design System Navy & Gold)
- **Database**: MySQL / MariaDB
- **Automation & Testing**: GitHub Actions (CI & CD deploy ke cPanel), PHPUnit (37+ tests)

---

## 🚀 Perintah Lokal Cepat

### Install & Setup

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### Jalankan Development Server

```bash
npm run dev
php artisan serve
```

### Verifikasi & Testing

```bash
vendor/bin/pint --test
php artisan test
npm run build
```

---

## 🚢 CI/CD & Deployment

Proyek ini telah dilengkapi dengan **GitHub Actions Workflow**:
- `.github/workflows/ci.yml`: Menjalankan pengujian otomatis (*automated tests*) dan verifikasi kode.
- `.github/workflows/deploy.yml`: Mengotomatisasi *build asset* dan *deploy* ke cPanel via SSH/SCP setiap ada *push* ke *branch* `main`.

Detail konfigurasi server dan *environment production* dapat dibaca di **[`docs/GO-LIVE.md`](docs/GO-LIVE.md)**.

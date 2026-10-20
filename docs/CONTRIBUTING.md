# Panduan Kontribusi (Contributing Guidelines)

Terima kasih telah berkontribusi untuk pengembanan website resmi **Bandara Kalimarau**!

## Standar Kode & Workflow

1. **Alur Kerja Git**:
   - Selalu buat *branch* baru dari `main` untuk setiap fitur/bugfix (`feat/nama-fitur` atau `fix/nama-bug`).
   - Buat Pull Request (PR) ke *branch* `main`.

2. **Formatting Kode (Laravel Pint)**:
   - Jalankan pemformat kode otomatis sebelum melakukan commit:
     ```bash
     vendor/bin/pint
     ```

3. **Pengujian (Automated Testing)**:
   - Pastikan seluruh *test suite* lulus 100% tanpa error:
     ```bash
     php artisan test
     ```

4. **Kompilasi Asset**:
   - Pastikan asset terkompilasi bersih:
     ```bash
     npm run build
     ```

5. **Prinsip Desain UI**:
   - Ikuti pedoman desain utama di [`PRODUCT.md`](PRODUCT.md) dan kaidah visual *Golden Standard* (Navy `#0A192F` & Gold `#D4AF37`, breadcrumb terstruktur, dan header putih).

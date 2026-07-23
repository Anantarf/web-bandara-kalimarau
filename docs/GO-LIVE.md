# Go-Live Security Checklist

## Checklist Cepat Sebelum Upload ke Hosting

1. **Commit dulu semua perubahan lokal** yang belum masuk git (`git status` harus bersih) — kalau tidak, fitur backup/CSP/Sentry/test terbaru tidak ikut ke server.
2. **Jangan copy `.env` lokal ke server.** Nilai berikut WAJIB beda antara lokal dan production:

   | Variabel | Lokal | Production |
   | --- | --- | --- |
   | `APP_ENV` | `local` | `production` |
   | `APP_DEBUG` | `true` | `false` ⚠️ paling kritis — kalau lupa, stack trace error bisa kebaca publik |
   | `APP_URL` | `http://127.0.0.1:8000` | `https://bandara-kalimarau.com` |
   | `APP_KEY` | punya lokal | generate baru (`php artisan key:generate`) |
   | `LOG_CHANNEL` | `stack` | `daily` |
   | `SESSION_ENCRYPT` / `SESSION_SECURE_COOKIE` | `false` | `true` |
   | `MAIL_MAILER` | `log` | mailer asli kalau perlu kirim email |
   | `SENTRY_LARAVEL_DSN` | kosong | isi (daftar gratis di sentry.io) — opsional tapi disarankan |

   | `SEED_ADMIN_PASSWORD` | kosong/dev | password awal admin yang kuat, hanya saat seed pertama |

3. **Jalankan di server setelah upload** (urutan penting):

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan test
   ```

4. **Set permission** `storage` & `bootstrap/cache` — lihat bagian "Server permissions" di bawah.
5. **Pasang cron** untuk Laravel scheduler (backup otomatis harian butuh ini) — lihat "Automated recurring backup" di bawah.
6. Verifikasi pasca-deploy: HTTPS aktif, form kontak, login admin, upload media, `robots.txt`, `sitemap.xml`, dan log aplikasi tidak error.

Detail lengkap tiap poin ada di bagian-bagian di bawah ini.

## Production environment

- Set `APP_ENV=production`, `APP_DEBUG=false`, and `APP_URL=https://bandara-kalimarau.com`.
- Set `SESSION_ENCRYPT=true`, `SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, and `SESSION_SAME_SITE=lax`.
- Set `LOG_CHANNEL=daily` (the default `single` channel never rotates and will grow unbounded on a long-running server). `LOG_DAILY_DAYS` defaults to 14, adjust if needed.
- Set `SENTRY_LARAVEL_DSN` (create a free project at sentry.io) so production errors are actually reported somewhere instead of only sitting in a log file nobody watches. `sentry/sentry-laravel` is already installed and wired in `bootstrap/app.php`; it stays inert until this DSN is set.
- Generate a unique `APP_KEY`; do not copy `.env` from local development.
- Set `SEED_ADMIN_EMAIL`, `SEED_ADMIN_USERNAME`, `SEED_ADMIN_NAME`, and a strong `SEED_ADMIN_PASSWORD` before running `php artisan db:seed --force`. Production seeding intentionally fails if `SEED_ADMIN_PASSWORD` is empty.
- Keep `.env`, SQL dumps, `backups/`, and `_quarantine*/` outside the deploy artifact.

## Server permissions

Run these commands on the production server after replacing `www-data` with the web-server user:

```bash
chown -R www-data:www-data storage bootstrap/cache
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

The application code must not be writable by the web-server user.

## Automated recurring backup

`spatie/laravel-backup` is installed and scheduled (`routes/console.php`) to run
`backup:run` daily at 01:00 and `backup:clean` at 01:30, backing up the database
plus everything under `storage/app/public` (uploaded media/documents — the
things git does not track). This only runs if the server's crontab has the
standard Laravel entry:

```cron
* * * * * cd /path/to/kalimarau && php artisan schedule:run >> /dev/null 2>&1
```

By default backups land on the `local` disk (`storage/app/`), i.e. still on
the same server — for real disaster recovery, add an off-server disk (S3 or
similar) to `'disks'` in `config/backup.php` before launch.

## Backup before deployment

The daily automated backup above is not a substitute for a pre-deploy backup —
create an off-server backup before every production deployment too. Store the
database dump and media archive outside the application directory, then verify
both archives can be read.

```bash
backup_dir="/srv/backups/kalimarau/$(date +%F-%H%M%S)"
mkdir -p "$backup_dir"
mysqldump --single-transaction --routines --triggers -u "$DB_USERNAME" -p "$DB_DATABASE" | gzip > "$backup_dir/database.sql.gz"
tar -C /path/to/kalimarau/storage/app -czf "$backup_dir/media.tar.gz" public/media
gzip -t "$backup_dir/database.sql.gz"
tar -tzf "$backup_dir/media.tar.gz" > /dev/null
```

Use credentials from the production environment only in the terminal session, not in shell history or source files.

## Deploy verification

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan test
```

After domain switch, verify HTTPS, the contact form, admin login, media upload, `robots.txt`, `sitemap.xml`, and application logs.

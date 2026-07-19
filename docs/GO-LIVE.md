# Go-Live Security Checklist

## Production environment

- Set `APP_ENV=production`, `APP_DEBUG=false`, and the HTTPS production `APP_URL`.
- Set `SESSION_ENCRYPT=true`, `SESSION_SECURE_COOKIE=true`, `SESSION_HTTP_ONLY=true`, and `SESSION_SAME_SITE=lax`.
- Generate a unique `APP_KEY`; do not copy `.env` from local development.
- Keep `.env`, SQL dumps, `backups/`, and `_quarantine*/` outside the deploy artifact.

## Server permissions

Run these commands on the production server after replacing `www-data` with the web-server user:

```bash
chown -R www-data:www-data storage bootstrap/cache
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

The application code must not be writable by the web-server user.

## Backup before deployment

Create an off-server backup before every production deployment. Store the database dump and media archive outside the application directory, then verify both archives can be read.

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
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan test
```

After domain switch, verify HTTPS, the contact form, admin login, media upload, `robots.txt`, `sitemap.xml`, and application logs.

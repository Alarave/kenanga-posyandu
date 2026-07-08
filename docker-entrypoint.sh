#!/bin/bash
set -e

# ── 1. Configure Port ────────────────────────────────────────────────────────
# Railway injects $PORT at runtime. Default to 8080 if not set.
PORT="${PORT:-8080}"
echo "==> Container starting on port $PORT"

# Apache config uses port 80 by default (not modified at build time).
# Update it now to use $PORT.
sed -i "s/Listen 80$/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# ── 2. Fix Apache MPM (runtime safety net) ───────────────────────────────────
# Remove any event/worker MPM symlinks that might cause "More than one MPM" error.
rm -f /etc/apache2/mods-enabled/mpm_event.load \
      /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_worker.load \
      /etc/apache2/mods-enabled/mpm_worker.conf

# Ensure mpm_prefork is enabled (required for mod_php).
[ -f /etc/apache2/mods-enabled/mpm_prefork.load ] || \
    ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
[ -f /etc/apache2/mods-enabled/mpm_prefork.conf ] || \
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

echo "==> Apache MPM: mpm_prefork enabled, event/worker removed"

# ── 3. Laravel Storage Permissions ──────────────────────────────────────────
echo "==> Fixing storage permissions..."
mkdir -p /var/www/storage/framework/views \
         /var/www/storage/framework/cache \
         /var/www/storage/framework/sessions \
         /var/www/storage/logs \
         /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Clear cached/compiled views to prevent stale tempnam issues
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# ── 4. Laravel Setup ─────────────────────────────────────────────────────────
echo "==> Creating storage symlink..."
rm -rf /var/www/public/storage
php artisan storage:link

echo "==> Running database migrations..."
php artisan migrate --force
php artisan db:seed --class=ArticleSeeder --force
php artisan db:seed --class=GallerySeeder --force

# ── 4. Start Apache ──────────────────────────────────────────────────────────
echo "==> Starting Apache on port $PORT..."
exec apache2-foreground

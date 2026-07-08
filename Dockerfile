FROM php:8.3-apache

# ── 1. Install PHP extensions ─────────────────────────────────────────────────
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_pgsql pgsql zip mbstring exif pcntl bcmath xml

# ── 2. Install Node.js (all apt installs must happen BEFORE Apache config) ────
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── 3. Configure Apache document root ─────────────────────────────────────────
RUN sed -i '/\<Directory \/var\/www\/\>/,/\<\/Directory\>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ── 4. Fix Apache MPM conflict ─────────────────────────────────────────────────
#    Done LAST (after all apt installs) so nothing can re-enable mpm_event.
#    Direct symlink removal is more reliable than a2dismod.
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
          /etc/apache2/mods-enabled/mpm_worker.conf && \
    a2enmod mpm_prefork rewrite headers

# ── 5. Install Composer ────────────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ── 6. Application files ───────────────────────────────────────────────────────
WORKDIR /var/www
COPY . /var/www

RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

EXPOSE 8080

# ── 7. Runtime startup ────────────────────────────────────────────────────────
#    Re-remove MPM symlinks at runtime (safety net), configure port from
#    Railway's injected $PORT env var, then start Apache.
CMD ["bash", "-c", "\
    rm -f /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
          /etc/apache2/mods-enabled/mpm_worker.conf; \
    a2enmod mpm_prefork 2>/dev/null || true; \
    PORT=${PORT:-8080}; \
    sed -i \"s/Listen 80$/Listen $PORT/\" /etc/apache2/ports.conf; \
    sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:$PORT>/\" /etc/apache2/sites-available/000-default.conf; \
    rm -rf public/storage && \
    php artisan storage:link && \
    php artisan migrate --force && \
    apache2-foreground"]

FROM php:8.3-apache

# ── 1. PHP Extensions ─────────────────────────────────────────────────────────
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_pgsql pgsql zip mbstring exif pcntl bcmath xml

# ── 2. Node.js (must run before Apache config to avoid re-enabling MPMs) ──────
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ── 3. Apache Configuration ───────────────────────────────────────────────────
# Allow .htaccess overrides
RUN sed -i '/\<Directory \/var\/www\/\>/,/\<\/Directory\>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Suppress FQDN warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set document root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable required modules
RUN a2enmod rewrite headers

# ── 4. Fix Apache MPM (AFTER all apt installs) ────────────────────────────────
# Directly remove event/worker symlinks — more reliable than a2dismod.
# This runs LAST so no subsequent apt-get can re-enable conflicting MPMs.
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
          /etc/apache2/mods-enabled/mpm_worker.conf && \
    ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load && \
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

# ── 5. Composer & Application ─────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# Make entrypoint executable
RUN chmod +x /var/www/docker-entrypoint.sh

EXPOSE 8080

# Use dedicated startup script (handles port + MPM + Laravel setup)
CMD ["/var/www/docker-entrypoint.sh"]

FROM php:8.3-apache

# Copy the php-extension-installer script from the official image
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install system dependencies and PHP extensions
RUN install-php-extensions gd pdo_pgsql pgsql zip mbstring exif pcntl bcmath xml

# Configure Apache document root
RUN sed -i '/\<Directory \/var\/www\/\>/,/\<\/Directory\>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Fix MPM conflict - explicitly disable event/worker, enable prefork (required for mod_php)
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork rewrite headers

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js & npm (LTS v22)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . /var/www

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install npm dependencies and build assets for production
RUN npm install && npm run build

# Expose default port (Railway overrides via $PORT env var at runtime)
EXPOSE 8080

# Configure Apache port dynamically from Railway's $PORT at container startup
CMD ["bash", "-c", "PORT=${PORT:-8080} && sed -i \"s/Listen 80$/Listen $PORT/\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:$PORT>/\" /etc/apache2/sites-available/000-default.conf && rm -rf public/storage && php artisan storage:link && php artisan migrate --force && apache2-foreground"]

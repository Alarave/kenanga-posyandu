FROM php:8.3-cli

# Copy the php-extension-installer script from the official image
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install system dependencies and PHP extensions
RUN install-php-extensions gd pdo_pgsql pgsql zip mbstring exif pcntl bcmath xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js & npm (latest LTS node version 22)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . /var/www

# Install Composer dependencies (including production optimization)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install npm dependencies and build assets for production
RUN npm install && npm run build

# Expose port 8080
EXPOSE 8080

# Run migrations and start the server using Laravel's artisan serve
CMD ["bash", "-c", "rm -rf public/storage && php artisan storage:link && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]

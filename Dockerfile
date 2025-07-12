# Use an official PHP image as a base
FROM php:8.0-fpm

# Install necessary dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# Set the working directory inside the container
WORKDIR /var/www

# Copy the application into the container
COPY . .

# Install Composer dependencies
RUN composer install

# Install npm dependencies
RUN npm install

# Expose port 8080 for the application
EXPOSE 8080

# Set the entrypoint for the application
CMD ["php-fpm"]

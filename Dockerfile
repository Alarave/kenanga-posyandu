# Use Railpack for auto-detection with explicit extensions
FROM ghcr.io/railwayapp/railpack:latest

# Install PHP GD extension for phpspreadsheet
RUN install-php-extensions gd ctype curl dom fileinfo filter hash mbstring openssl pcre pdo session tokenizer xml pdo_pgsql

FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    ffmpeg

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip

# Configure PHP upload limits
RUN echo "upload_max_filesize = 500M\npost_max_size = 500M\nmemory_limit = 512M\nmax_execution_time = 300\nmax_input_time = 300" > /usr/local/etc/php/conf.d/uploads.ini

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer update --no-dev --optimize-autoloader

# Install Node dependencies and build frontend assets (Tailwind)
RUN npm install
RUN npm run build

# Ensure correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Update Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache to listen on port 80
RUN sed -i 's/Listen ${PORT}/Listen 80/g' /etc/apache2/ports.conf || true

# Run migrations and start Apache
CMD php artisan migrate --force && apache2-foreground

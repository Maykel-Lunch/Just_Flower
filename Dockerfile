# Base image with PHP 8.2 and FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    git \
    curl \
    supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql mbstring zip gd opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Fix permissions
RUN chown -R www-data:www-data /var/www

# Copy Nginx config
COPY deploy/nginx/default.conf /etc/nginx/sites-available/default

# Copy Supervisor config to manage both services
COPY deploy/supervisord.conf /etc/supervisord.conf

# Expose HTTP port
EXPOSE 80

# Start both Nginx and PHP-FPM using Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
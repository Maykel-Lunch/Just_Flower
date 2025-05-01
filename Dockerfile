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
    libpq-dev \
    unzip \
    git \
    curl \
    supervisor


# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip gd opcache


# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set proper permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Generate Laravel APP_KEY only if .env is present
RUN if [ -f .env ]; then php artisan key:generate; fi

# Run database migrations (important!)
RUN php artisan migrate --force || echo "Migration failed but continuing..."

# Copy Nginx config
COPY deploy/nginx/default.conf /etc/nginx/sites-available/default

# Enable site config
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Copy Supervisor config
COPY deploy/supervisord.conf /etc/supervisord.conf

# Expose HTTP port
EXPOSE 80

# Run Supervisor to start Nginx + PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

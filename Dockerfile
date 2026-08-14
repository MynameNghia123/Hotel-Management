FROM php:8.2-fpm

# Install system dependencies (including libpq-dev for PostgreSQL)
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    nodejs npm libpq-dev nginx \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install Node dependencies and build assets (Vite)
RUN npm install && npm run build

# Configure Nginx
RUN rm -f /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Set correct permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && chmod +x /var/www/scripts/00-laravel-deploy.sh

# Expose port 80 for the PaaS (Render, Koyeb, etc.)
EXPOSE 80

# Start PHP-FPM in background and Nginx in foreground
CMD sh -c "/var/www/scripts/00-laravel-deploy.sh && php-fpm -D && nginx -g 'daemon off;'"
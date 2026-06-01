FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Fix MPM conflict - disable mpm_event, enable mpm_prefork
RUN a2dismod mpm_event || true
RUN a2enmod mpm_prefork

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy semua file
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Install dan build Vite assets (jika ada)
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy .env.example ke .env (kalau ada)
RUN if [ -f .env.example ]; then cp .env.example .env; fi

# Generate APP_KEY
RUN php artisan key:generate --force

# Cache config dan routes
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 80
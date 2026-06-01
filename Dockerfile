FROM php:8.2-apache

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

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Matikan semua MPM, aktifkan prefork
RUN a2dismod mpm_event mpm_worker
RUN a2enmod mpm_prefork
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN npm install && npm run build || true

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN cp .env.example .env || true
RUN php artisan key:generate --force

EXPOSE 80

CMD ["apache2-foreground"]
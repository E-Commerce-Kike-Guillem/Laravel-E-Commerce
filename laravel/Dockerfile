FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql gd zip

WORKDIR /var/www

COPY composer.json composer.lock* ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
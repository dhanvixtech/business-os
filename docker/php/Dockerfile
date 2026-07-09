FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    pdo_mysql \
    bcmath \
    zip \
    intl \
    gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/api

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/views \
    storage/framework/sessions \
    bootstrap/cache

RUN chown -R www-data:www-data /var/www
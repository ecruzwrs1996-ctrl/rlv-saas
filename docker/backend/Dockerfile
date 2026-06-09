FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    gd \
    zip \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

EXPOSE 80
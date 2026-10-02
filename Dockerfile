FROM php:8.3-apache

# Install dependencies sistem & ekstensi PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    git \
    libpq-dev \
    default-mysql-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip gd

# Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Arahkan DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Salin Composer binary terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory & salin kode
WORKDIR /var/www/html
COPY . /var/www/html

# Berikan hak akses kepada user www-data
RUN chown -R www-data:www-data /var/www/html

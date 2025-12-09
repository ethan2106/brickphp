FROM php:8.3-fpm-alpine

# Extensions PHP nécessaires + PCOV pour coverage
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libzip-dev \
    autoconf \
    g++ \
    make \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        opcache \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apk del autoconf g++ make

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Config PHP
RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory.ini \
    && echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/memory.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/memory.ini

WORKDIR /var/www/html

# Copier composer.json et installer les dépendances (production)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier le reste du code
COPY . .

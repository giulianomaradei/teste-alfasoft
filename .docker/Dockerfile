FROM composer:2.3 AS composer
FROM php:8.1-fpm-bullseye
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update; \
    apt-get install --yes --quiet --no-install-recommends \
        openssl \
        libxml2-dev \
        libpq-dev \
        libzip-dev \
        libonig-dev \
        libmcrypt-dev \
        libgmp-dev \
        libpng-dev \
        git \
        zip \
        unzip \
        libsqlite3-dev \
        libicu-dev; \
    docker-php-ext-install pcntl \
        bcmath \
        mysqli \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        pgsql \
        zip \
        gd \
        gmp \
        intl; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug gd; \
    rm -rf /var/lib/apt/lists/*

#COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY .docker/local.ini /usr/local/etc/php/conf.d/zzz_app.ini

ARG user
ARG uid
RUN useradd -G www-data,root -u $uid -d /home/$user $user && echo "$user:$user" | chpasswd && adduser $user sudo
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
USER $user
CMD ["php-fpm"]

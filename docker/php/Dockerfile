FROM composer:2.3.10 as composer
FROM php:8.1-fpm as php

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update && \
    apt install git libzip-dev -yqq && \
    rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f xdebug && \
    rm -rf /tmp/pear

RUN docker-php-ext-install zip pdo_mysql

RUN docker-php-ext-enable xdebug

WORKDIR /app


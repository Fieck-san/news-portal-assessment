FROM composer:2 AS composer

FROM php:8.3-cli-alpine

RUN apk add --no-cache bash icu-dev mysql-client oniguruma-dev sqlite-dev zip libzip-dev \
    && docker-php-ext-install intl mbstring pdo_mysql pdo_sqlite zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

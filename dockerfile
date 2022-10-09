FROM php:8.1-fpm

RUN apt-get update -y && apt-get upgrade \
    && apt install -y zip git \
    && pecl install mongodb && docker-php-ext-enable mongodb

COPY . /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
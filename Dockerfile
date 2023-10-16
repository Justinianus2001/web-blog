FROM php:8.2-fpm-alpine

LABEL maintainer="Hoang (Justinianus) Le Ngoc (lengochoang681@gmail.com)"

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-enable pdo pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
COPY .env.docker .env
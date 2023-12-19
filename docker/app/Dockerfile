# Dockerfile
FROM php:8.1-fpm

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy xdebug configuration
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
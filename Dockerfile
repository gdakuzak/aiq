FROM php:8.3.4-fpm-alpine AS base
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apk update && apk upgrade && apk add --no-cache libxml2-dev bzip2-dev libpng-dev libpq curl postgresql-dev busybox-extras linux-headers ${PHPIZE_DEPS}
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install dom
RUN docker-php-ext-install bz2
RUN docker-php-ext-install gd
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install xml
RUN docker-php-ext-install bcmath
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=develop,coverage" > /usr/local/etc/php/conf.d/00_xdebug.ini
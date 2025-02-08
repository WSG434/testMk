FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      curl

RUN docker-php-ext-install bcmath 
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./conf.d/* /usr/local/etc/php/conf.d/
COPY php.ini /usr/local/etc/php/

WORKDIR /var/www

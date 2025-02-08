FROM php:8.3-fpm

RUN printf "deb http://mirror.yandex.ru/debian/ bookworm main contrib non-free non-free-firmware \n deb-src http://mirror.yandex.ru/debian/ bookworm main contrib non-free non-free-firmware \n deb http://security.debian.org/debian-security bookworm-security main contrib non-free non-free-firmware \n deb-src http://security.debian.org/debian-security bookworm-security main contrib non-free non-free-firmware \n deb http://mirror.yandex.ru/debian/ bookworm-updates main contrib non-free non-free-firmware \n deb-src http://mirror.yandex.ru/debian/ bookworm-updates main contrib non-free non-free-firmware" > /etc/apt/sources.list

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

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

COPY ./conf.d/* /usr/local/etc/php/conf.d/
COPY php.ini /usr/local/etc/php/

WORKDIR /var/www

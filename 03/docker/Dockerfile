FROM php:7.3-fpm

ARG APCU_VERSION=5.1.18

COPY ./app /var/app

RUN apt-get update \
    && apt-get -y install libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && pecl install apcu-${APCU_VERSION} \
    && docker-php-ext-enable apcu \
    && rm -rf /tmp/* /var/cache/apk/* /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php ; mv composer.phar /usr/bin/composer

RUN cd /var/app && composer install

ENTRYPOINT php-fpm -F
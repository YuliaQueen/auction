FROM php:8.3-cli-alpine

RUN apk add --no-cache autoconf g++ make linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear

RUN apk add --no-cache unzip

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app

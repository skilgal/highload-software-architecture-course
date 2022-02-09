FROM php:8.0-fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && apk add --no-cache git \
    $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

RUN chmod +x /usr/bin/wait-for-it

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD composer install;  php-fpm

EXPOSE 9000

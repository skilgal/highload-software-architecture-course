FROM php:8.0-fpm-alpine

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash nano\
    && rm -rf /var/cache/apk/*

RUN apk add --update --no-cache freetype-dev \
                                libjpeg-turbo-dev \
                                jpeg-dev \
                                libpng-dev \
    && docker-php-ext-install gd

ARG TEMPLATE_PATH

COPY ${TEMPLATE_PATH} /var/www/html/index.php

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html", "./index.php"]

EXPOSE 9000

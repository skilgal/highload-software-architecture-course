FROM php:8.0-fpm-alpine

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && rm -rf /var/cache/apk/*

ARG TEMPLATE

COPY ${TEMPLATE} /var/www/html/index.php

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html", "./index.php"]

EXPOSE 9000

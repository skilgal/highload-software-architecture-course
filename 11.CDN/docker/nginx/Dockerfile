FROM nginx:alpine

COPY nginx.conf /etc/nginx/

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash

RUN apk add --no-cache curl

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

# Remove the default conf
RUN rm /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

CMD ["nginx"]

EXPOSE 80

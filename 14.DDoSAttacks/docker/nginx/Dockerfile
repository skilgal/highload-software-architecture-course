FROM nginx:alpine

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash

RUN apk add --no-cache curl iptables

COPY ./iptables.sh /usr/local/bin/tweak-iptables

ARG TWEAK_IPTABLES=false
RUN if [ ${TWEAK_IPTABLES} = true ]; then \
  chmod +x /usr/local/bin/tweak-iptables; \
  /usr/local/bin/tweak-iptables; \
fi

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

WORKDIR /var/www/html

CMD ["nginx"]

EXPOSE 80
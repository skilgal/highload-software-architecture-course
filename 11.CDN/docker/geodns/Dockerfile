FROM sameersbn/bind:latest

RUN mkdir -p /etc/bind/zones/ \
    && mkdir -p /etc/bind/geo/

COPY geo/* /etc/bind/geo/
COPY zones/* /etc/bind/zones/

COPY named.* /etc/bind/

EXPOSE 53/udp 53/tcp

CMD ["/usr/sbin/named"]

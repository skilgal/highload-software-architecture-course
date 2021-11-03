#!/bin/bash

mkdir -p ./data/grafana

docker-compose up -d elasticsearch nginx php-fpm workspace mongo influxdb telegraf grafana

echo "Grafana: http://127.0.0.1:3000 - admin/admin"
echo "Index page via nginx http://localhost"


#!/usr/bin/env bash

concurrency=( 10 30 50 100 )
operations=( 'write' 'read' )
queues=( 'beanstalkd' 'redis_aof' 'redis_rdb' )

for op in "${operations[@]}"; do
    for queue in "${queues[@]}"; do
        for con in "${concurrency[@]}"; do
            echo "Run siege with $con threads for '$op' operation to the '$queue' queue "
            siege -c$con -t10S http://localhost:8080/$op/$queue | grep "Transaction"
        done
    done
done

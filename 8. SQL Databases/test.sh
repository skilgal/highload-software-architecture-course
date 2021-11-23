#!/bin/bash

concurrent_users=( 10 25 50 100 )
tx_commits=( 0 1 2 )

    for users in "${concurrent_users[@]}"
    do


for tx in "${tx_commits[@]}"
do
    echo ""
    echo "Set 'innodb_flush_log_at_trx_commit' to $tx"
    mycli db -u root -p password -e "SET GLOBAL innodb_flush_log_at_trx_commit=$tx;"

        mycli db -u user -p password -e "delete from users"
        siege -q --time=30s --concurrent=$users "http://localhost:9000/add POST"
        mycli db -u user -p password -e "select $tx, $users, count(*) from users"
        sleep 10
    done
done
